<?php

namespace App\Controller;

use App\Entity\CommunityOrganization;
use App\Entity\AdminUser;
use App\Entity\Event;
use App\Entity\GalleryImage;
use App\Entity\Page;
use App\Entity\PageMedia;
use App\Entity\SiteSetting;
use App\Entity\SocialLink;
use App\Form\AdminUserType;
use App\Form\CommunityOrganizationType;
use App\Form\EventType;
use App\Form\GalleryImageType;
use App\Form\PageMediaType;
use App\Form\PageType;
use App\Form\SiteSettingType;
use App\Form\SocialLinkType;
use App\Repository\AdminUserRepository;
use App\Repository\CommunityOrganizationRepository;
use App\Repository\EventRepository;
use App\Repository\GalleryImageRepository;
use App\Repository\PageMediaRepository;
use App\Repository\PageRepository;
use App\Repository\SiteSettingRepository;
use App\Repository\SocialLinkRepository;
use App\Service\ImageUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/admin')]
class AdminController extends AbstractController
{
    public function __construct(private readonly ImageUploader $imageUploader)
    {
    }

    #[Route('', name: 'admin_dashboard')]
    public function dashboard(PageRepository $pages, GalleryImageRepository $images, EventRepository $events, SocialLinkRepository $socialLinks, CommunityOrganizationRepository $organizations, AdminUserRepository $users): Response
    {
        return $this->render('admin/dashboard.html.twig', [
            'pages' => $pages->findBy([], ['position' => 'ASC']),
            'images' => $images->findBy([], ['position' => 'ASC']),
            'events' => $events->findBy([], ['featured' => 'DESC', 'position' => 'ASC', 'eventDate' => 'DESC']),
            'socialLinks' => $socialLinks->findBy([], ['position' => 'ASC']),
            'organizations' => $organizations->findBy([], ['position' => 'ASC']),
            'users' => $users->findBy([], ['name' => 'ASC']),
        ]);
    }

    #[Route('/editor-media/upload', name: 'admin_editor_media_upload', methods: ['POST'])]
    public function uploadEditorMedia(Request $request): JsonResponse
    {
        $token = (string) ($request->request->get('_token') ?: $request->headers->get('X-CSRF-TOKEN'));
        if (!$this->isCsrfTokenValid('editor_media_upload', $token) && !$this->isSameOriginAdminRequest($request)) {
            return $this->json(['error' => 'Jeton CSRF invalide.'], Response::HTTP_FORBIDDEN);
        }

        $file = $request->files->get('media');
        if (!$file instanceof UploadedFile) {
            return $this->json(['error' => 'Aucun fichier reçu.'], Response::HTTP_BAD_REQUEST);
        }

        try {
            if ($this->isVideoUpload($file)) {
                $url = $this->imageUploader->uploadVideo($file, 'editeur');

                return $this->json(['url' => $url, 'type' => 'video']);
            }

            $maxWidth = $request->request->getInt('max_width') ?: null;
            $maxHeight = $request->request->getInt('max_height') ?: null;
            $url = $this->imageUploader->uploadAsWebp($file, 'editeur', $maxWidth, $maxHeight);
        } catch (\Throwable $exception) {
            return $this->json(['error' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return $this->json(['url' => $url, 'type' => 'image']);
    }

    private function isVideoUpload(UploadedFile $file): bool
    {
        $extension = strtolower($file->getClientOriginalExtension() ?: pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION));

        return in_array($extension, ['mp4', 'webm', 'mov'], true);
    }

    #[Route('/editor-media/upload-video-chunk', name: 'admin_editor_video_chunk_upload', methods: ['POST'])]
    public function uploadEditorVideoChunk(Request $request): JsonResponse
    {
        $token = (string) ($request->request->get('_token') ?: $request->headers->get('X-CSRF-TOKEN'));
        if (!$this->isCsrfTokenValid('editor_media_upload', $token) && !$this->isSameOriginAdminRequest($request)) {
            return $this->json(['error' => 'Jeton CSRF invalide.'], Response::HTTP_FORBIDDEN);
        }

        $chunk = $request->files->get('chunk');
        if (!$chunk instanceof UploadedFile) {
            return $this->json(['error' => $this->getMissingUploadMessage($request)], Response::HTTP_BAD_REQUEST);
        }

        $uploadId = preg_replace('/[^a-zA-Z0-9_-]/', '', (string) $request->request->get('upload_id'));
        $originalName = basename((string) $request->request->get('original_name', 'video.mp4'));
        $index = $request->request->getInt('index', -1);
        $total = $request->request->getInt('total', 0);

        if (!$uploadId || $index < 0 || $total < 1 || $total > 160) {
            return $this->json(['error' => 'Import vidéo invalide.'], Response::HTTP_BAD_REQUEST);
        }

        $chunkDir = $this->getVideoChunkDir($uploadId);
        if (!is_dir($chunkDir)) {
            mkdir($chunkDir, 0775, true);
        }

        $chunkPath = $chunkDir.DIRECTORY_SEPARATOR.sprintf('%05d.part', $index);
        $chunk->move($chunkDir, basename($chunkPath));

        if ($index + 1 < $total) {
            return $this->json(['done' => false]);
        }

        try {
            $assembledPath = $chunkDir.DIRECTORY_SEPARATOR.'assembled-video.tmp';
            $output = fopen($assembledPath, 'wb');
            if (!$output) {
                throw new \RuntimeException('Impossible de préparer la vidéo.');
            }

            for ($i = 0; $i < $total; $i++) {
                $partPath = $chunkDir.DIRECTORY_SEPARATOR.sprintf('%05d.part', $i);
                if (!is_file($partPath)) {
                    fclose($output);
                    throw new \RuntimeException('Morceau vidéo manquant. Réessayez l import.');
                }

                $input = fopen($partPath, 'rb');
                if (!$input) {
                    fclose($output);
                    throw new \RuntimeException('Impossible de lire un morceau vidéo.');
                }
                stream_copy_to_stream($input, $output);
                fclose($input);
            }
            fclose($output);

            $url = $this->imageUploader->uploadVideoFromPath($assembledPath, $originalName, 'editeur');
            $this->removeDirectory($chunkDir);
        } catch (\Throwable $exception) {
            $this->removeDirectory($chunkDir);

            return $this->json(['error' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return $this->json(['done' => true, 'url' => $url, 'type' => 'video']);
    }

    private function getVideoChunkDir(string $uploadId): string
    {
        return $this->getParameter('kernel.project_dir').DIRECTORY_SEPARATOR.'var'.DIRECTORY_SEPARATOR.'editor-video-chunks'.DIRECTORY_SEPARATOR.$uploadId;
    }

    private function removeDirectory(string $dir): void
    {
        if (!is_dir($dir)) {
            return;
        }

        foreach (glob($dir.DIRECTORY_SEPARATOR.'*') ?: [] as $path) {
            if (is_file($path)) {
                unlink($path);
            }
        }

        rmdir($dir);
    }

    private function getMissingUploadMessage(Request $request): string
    {
        $contentLength = (int) $request->server->get('CONTENT_LENGTH', 0);
        $postMaxSize = $this->toBytes((string) ini_get('post_max_size'));

        if ($contentLength > 0 && $postMaxSize > 0 && $contentLength > $postMaxSize) {
            return 'Fichier trop lourd pour la configuration PHP actuelle. Augmentez post_max_size et upload_max_filesize sur le serveur.';
        }

        return 'Aucun fichier reçu. Vérifiez que le fichier est bien sélectionné et que sa taille ne dépasse pas la limite du serveur.';
    }

    private function toBytes(string $value): int
    {
        $value = trim($value);
        if ($value === '') {
            return 0;
        }

        $unit = strtolower($value[-1]);
        $number = (float) $value;

        return match ($unit) {
            'g' => (int) ($number * 1024 * 1024 * 1024),
            'm' => (int) ($number * 1024 * 1024),
            'k' => (int) ($number * 1024),
            default => (int) $number,
        };
    }

    private function isSameOriginAdminRequest(Request $request): bool
    {
        if ($request->headers->get('Sec-Fetch-Site') === 'same-origin') {
            return true;
        }

        $referer = $request->headers->get('referer');
        if (!$referer) {
            return false;
        }

        $refererHost = parse_url($referer, PHP_URL_HOST);
        $refererPath = (string) parse_url($referer, PHP_URL_PATH);

        return $refererHost === $request->getHost() && str_starts_with($refererPath, '/admin');
    }

    #[Route('/home', name: 'admin_home_settings')]
    public function homeSettings(Request $request, EntityManagerInterface $em, SiteSettingRepository $settings): Response
    {
        $fields = [
            'hero_image',
            'hero_eyebrow_fr',
            'hero_eyebrow_en',
            'hero_eyebrow_ar',
            'hero_title_fr',
            'hero_title_en',
            'hero_title_ar',
            'hero_intro_fr',
            'hero_intro_en',
            'hero_intro_ar',
            'hero_primary_label_fr',
            'hero_primary_label_en',
            'hero_primary_label_ar',
            'hero_primary_url',
            'hero_secondary_label_fr',
            'hero_secondary_label_en',
            'hero_secondary_label_ar',
            'hero_secondary_url',
        ];

        if ($request->isMethod('POST')) {
            if (!$this->isCsrfTokenValid('homepage_settings', (string) $request->request->get('_token'))) {
                $this->addFlash('error', 'Jeton CSRF invalide.');

                return $this->redirectToRoute('admin_home_settings');
            }

            $uploadedHero = $request->files->get('hero_image_file');
            if ($uploadedHero instanceof UploadedFile) {
                try {
                    $request->request->set('hero_image', $this->imageUploader->uploadAsWebp($uploadedHero, 'accueil'));
                } catch (\Throwable $exception) {
                    $this->addFlash('error', $exception->getMessage());

                    return $this->redirectToRoute('admin_home_settings');
                }
            } else {
                $request->request->set('hero_image', $this->imageUploader->normalizeLocalImagePath((string) $request->request->get('hero_image', '')));
            }

            foreach ($fields as $key) {
                $setting = $settings->findOneBy(['settingKey' => $key]) ?? (new SiteSetting())->setSettingKey($key);
                $setting->setSettingValue(trim((string) $request->request->get($key, '')));
                $em->persist($setting);
            }

            $em->flush();
            $this->addFlash('success', 'Accueil enregistré.');

            return $this->redirectToRoute('admin_home_settings');
        }

        $values = [];
        foreach ($fields as $key) {
            $values[$key] = $settings->value($key);
        }

        return $this->render('admin/home_settings.html.twig', [
            'values' => $values,
        ]);
    }

    #[Route('/pages/new', name: 'admin_page_new')]
    #[Route('/pages/{id}/edit', name: 'admin_page_edit')]
    public function pageForm(Request $request, EntityManagerInterface $em, PageMediaRepository $pageMediaRepository, ?Page $page = null): Response
    {
        $page ??= new Page();

        return $this->handleForm($request, $em, $page, PageType::class, [
            'pageMedia' => $page->getId() ? $pageMediaRepository->findForPage($page) : [],
        ]);
    }

    #[Route('/pages/{pageId}/media/new', name: 'admin_page_media_new')]
    #[Route('/pages/{pageId}/media/{id}/edit', name: 'admin_page_media_edit')]
    public function pageMediaForm(Request $request, EntityManagerInterface $em, PageRepository $pages, ?PageMedia $pageMedia = null, ?int $pageId = null): Response
    {
        $page = $pageMedia?->getPage() ?? ($pageId ? $pages->find($pageId) : null);
        if (!$page) {
            throw $this->createNotFoundException('Page introuvable');
        }

        $pageMedia ??= (new PageMedia())->setPage($page);

        return $this->handleForm($request, $em, $pageMedia, PageMediaType::class);
    }

    #[Route('/images/new', name: 'admin_image_new')]
    #[Route('/images/{id}/edit', name: 'admin_image_edit')]
    public function imageForm(Request $request, EntityManagerInterface $em, ?GalleryImage $image = null): Response
    {
        return $this->handleForm($request, $em, $image ?? new GalleryImage(), GalleryImageType::class);
    }

    #[Route('/events/new', name: 'admin_event_new')]
    #[Route('/events/{id}/edit', name: 'admin_event_edit')]
    public function eventForm(Request $request, EntityManagerInterface $em, ?Event $event = null): Response
    {
        return $this->handleForm($request, $em, $event ?? new Event(), EventType::class);
    }

    #[Route('/social/new', name: 'admin_social_new')]
    #[Route('/social/{id}/edit', name: 'admin_social_edit')]
    public function socialForm(Request $request, EntityManagerInterface $em, ?SocialLink $socialLink = null): Response
    {
        return $this->handleForm($request, $em, $socialLink ?? new SocialLink(), SocialLinkType::class);
    }

    #[Route('/organizations/new', name: 'admin_organization_new')]
    #[Route('/organizations/{id}/edit', name: 'admin_organization_edit')]
    public function organizationForm(Request $request, EntityManagerInterface $em, ?CommunityOrganization $organization = null): Response
    {
        return $this->handleForm($request, $em, $organization ?? new CommunityOrganization(), CommunityOrganizationType::class);
    }

    #[Route('/settings', name: 'admin_settings')]
    public function settings(SiteSettingRepository $settings): Response
    {
        $advancedSettings = array_filter(
            $settings->findBy([], ['settingKey' => 'ASC']),
            fn (SiteSetting $setting): bool => !$this->isHomepageSetting($setting->getSettingKey())
        );

        return $this->render('admin/settings.html.twig', [
            'settings' => $advancedSettings,
        ]);
    }

    #[Route('/settings/new', name: 'admin_setting_new')]
    #[Route('/settings/{id}/edit', name: 'admin_setting_edit')]
    public function settingForm(Request $request, EntityManagerInterface $em, ?SiteSetting $setting = null): Response
    {
        return $this->handleForm($request, $em, $setting ?? new SiteSetting(), SiteSettingType::class);
    }

    #[Route('/users', name: 'admin_users')]
    public function users(AdminUserRepository $users): Response
    {
        return $this->render('admin/users.html.twig', [
            'users' => $users->findBy([], ['name' => 'ASC']),
        ]);
    }

    #[Route('/users/new', name: 'admin_user_new')]
    #[Route('/users/{id}/edit', name: 'admin_user_edit')]
    public function userForm(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $hasher, ?AdminUser $adminUser = null): Response
    {
        $adminUser ??= new AdminUser();
        $form = $this->createForm(AdminUserType::class, $adminUser, ['is_edit' => null !== $adminUser->getId()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = (string) $form->get('plainPassword')->getData();
            if ($plainPassword !== '') {
                $adminUser->setPassword($hasher->hashPassword($adminUser, $plainPassword));
            }

            if (!$adminUser->getRoles()) {
                $adminUser->setRoles(['ROLE_CMS_ACCESS']);
            }

            $em->persist($adminUser);
            $em->flush();
            $this->addFlash('success', 'Modérateur enregistré.');

            if ((string) $request->request->get('_action') === 'save_stay') {
                return $this->redirectToRoute('admin_user_edit', ['id' => $adminUser->getId()]);
            }

            return $this->redirectToRoute('admin_users');
        }

        return $this->render('admin/form.html.twig', [
            'form' => $form,
            'entity' => $adminUser,
            'context' => [
                'section' => 'Modérateurs',
                'title' => $adminUser->getId() ? 'Modifier un modérateur' : 'Nouveau modérateur',
                'hint' => 'Définissez les accès par section du CMS.',
                'backRoute' => 'admin_users',
            ],
        ]);
    }

    #[Route('/pages/{id}/delete', name: 'admin_page_delete', methods: ['POST'])]
    public function deletePage(Request $request, EntityManagerInterface $em, Page $page): Response
    {
        return $this->deleteEntity($request, $em, $page, 'delete_page_'.$page->getId());
    }

    #[Route('/images/{id}/delete', name: 'admin_image_delete', methods: ['POST'])]
    public function deleteImage(Request $request, EntityManagerInterface $em, GalleryImage $image): Response
    {
        return $this->deleteEntity($request, $em, $image, 'delete_image_'.$image->getId());
    }

    #[Route('/events/{id}/delete', name: 'admin_event_delete', methods: ['POST'])]
    public function deleteEvent(Request $request, EntityManagerInterface $em, Event $event): Response
    {
        return $this->deleteEntity($request, $em, $event, 'delete_event_'.$event->getId());
    }

    #[Route('/social/{id}/delete', name: 'admin_social_delete', methods: ['POST'])]
    public function deleteSocial(Request $request, EntityManagerInterface $em, SocialLink $socialLink): Response
    {
        return $this->deleteEntity($request, $em, $socialLink, 'delete_social_'.$socialLink->getId());
    }

    #[Route('/organizations/{id}/delete', name: 'admin_organization_delete', methods: ['POST'])]
    public function deleteOrganization(Request $request, EntityManagerInterface $em, CommunityOrganization $organization): Response
    {
        return $this->deleteEntity($request, $em, $organization, 'delete_organization_'.$organization->getId());
    }

    #[Route('/pages/media/{id}/delete', name: 'admin_page_media_delete', methods: ['POST'])]
    public function deletePageMedia(Request $request, EntityManagerInterface $em, PageMedia $pageMedia): Response
    {
        return $this->deleteEntity($request, $em, $pageMedia, 'delete_page_media_'.$pageMedia->getId());
    }

    #[Route('/users/{id}/delete', name: 'admin_user_delete', methods: ['POST'])]
    public function deleteUser(Request $request, EntityManagerInterface $em, AdminUser $adminUser): Response
    {
        return $this->deleteEntity($request, $em, $adminUser, 'delete_user_'.$adminUser->getId(), 'admin_users');
    }

    private function handleForm(Request $request, EntityManagerInterface $em, object $entity, string $type, array $extra = []): Response
    {
        /** @var FormInterface $form */
        $form = $this->createForm($type, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->has('imageFile')) {
                $uploadedImage = $form->get('imageFile')->getData();
                if ($uploadedImage instanceof UploadedFile) {
                    try {
                        $uploadedPath = $this->imageUploader->uploadAsWebp($uploadedImage, $this->getUploadPrefix($entity));
                        if ($entity instanceof SiteSetting) {
                            $entity->setSettingValue($uploadedPath);
                        } elseif (method_exists($entity, 'setImageUrl')) {
                            $entity->setImageUrl($uploadedPath);
                        }
                    } catch (\Throwable $exception) {
                        $this->addFlash('error', $exception->getMessage());

                        return $this->redirectToRoute($entity instanceof PageMedia ? 'admin_page_edit' : 'admin_dashboard', $entity instanceof PageMedia ? ['id' => $entity->getPage()?->getId()] : []);
                    }
                } elseif ($entity instanceof SiteSetting && $this->isImageSetting($entity)) {
                    $entity->setSettingValue($this->imageUploader->normalizeLocalImagePath($entity->getSettingValue()));
                } elseif (method_exists($entity, 'getImageUrl') && method_exists($entity, 'setImageUrl')) {
                    $entity->setImageUrl($this->imageUploader->normalizeLocalImagePath($entity->getImageUrl()));
                }
            }

            $em->persist($entity);
            $em->flush();
            $this->addFlash('success', 'Contenu enregistré.');

            if ((string) $request->request->get('_action') === 'save_stay') {
                return $this->redirectToStayRoute($entity);
            }

            if ($entity instanceof PageMedia) {
                return $this->redirectToRoute('admin_page_edit', ['id' => $entity->getPage()?->getId()]);
            }

            return $this->redirectToRoute($entity instanceof SiteSetting ? 'admin_settings' : 'admin_dashboard');
        }

        return $this->render('admin/form.html.twig', [
            'form' => $form,
            'entity' => $entity,
            'context' => $this->getFormContext($entity),
            'editorMediaLibrary' => $this->getEditorMediaLibrary($em, $entity),
        ] + $extra);
    }

    private function redirectToStayRoute(object $entity): Response
    {
        if ($entity instanceof Page) {
            return $this->redirectToRoute('admin_page_edit', ['id' => $entity->getId()]);
        }

        if ($entity instanceof PageMedia) {
            return $this->redirectToRoute('admin_page_media_edit', [
                'pageId' => $entity->getPage()?->getId(),
                'id' => $entity->getId(),
            ]);
        }

        if ($entity instanceof GalleryImage) {
            return $this->redirectToRoute('admin_image_edit', ['id' => $entity->getId()]);
        }

        if ($entity instanceof Event) {
            return $this->redirectToRoute('admin_event_edit', ['id' => $entity->getId()]);
        }

        if ($entity instanceof SocialLink) {
            return $this->redirectToRoute('admin_social_edit', ['id' => $entity->getId()]);
        }

        if ($entity instanceof CommunityOrganization) {
            return $this->redirectToRoute('admin_organization_edit', ['id' => $entity->getId()]);
        }

        if ($entity instanceof SiteSetting) {
            return $this->redirectToRoute('admin_setting_edit', ['id' => $entity->getId()]);
        }

        return $this->redirectToRoute('admin_dashboard');
    }

    private function getEditorMediaLibrary(EntityManagerInterface $em, object $entity): array
    {
        $media = [];

        if ($entity instanceof Page && $entity->getId()) {
            foreach ($em->getRepository(PageMedia::class)->findBy(['page' => $entity], ['position' => 'ASC']) as $item) {
                $media[] = [
                    'url' => $item->getImageUrl(),
                    'label' => $item->getTitle(),
                    'caption' => $item->getCaption() ?: $item->getTitle(),
                    'source' => 'Page',
                ];
            }
        }

        foreach ($em->getRepository(GalleryImage::class)->findBy([], ['featured' => 'DESC', 'position' => 'ASC']) as $item) {
            $media[] = [
                'url' => $item->getImageUrl(),
                'label' => $item->getTitle(),
                'caption' => $item->getCredit() ? $item->getTitle().' - '.$item->getCredit() : $item->getTitle(),
                'source' => 'Galerie',
            ];
        }

        return $media;
    }

    private function deleteEntity(Request $request, EntityManagerInterface $em, object $entity, string $tokenId, string $fallbackRoute = 'admin_dashboard'): Response
    {
        if (!$this->isCsrfTokenValid($tokenId, (string) $request->request->get('_token'))) {
            $this->addFlash('error', 'Jeton CSRF invalide.');

            return $this->redirectToRoute($fallbackRoute);
        }

        $redirectRoute = $fallbackRoute;
        $redirectParams = [];
        if ($entity instanceof PageMedia && $entity->getPage()) {
            $redirectRoute = 'admin_page_edit';
            $redirectParams = ['id' => $entity->getPage()->getId()];
        }

        $em->remove($entity);
        $em->flush();
        $this->addFlash('success', 'Contenu supprimé.');

        return $this->redirectToRoute($redirectRoute, $redirectParams);
    }

    private function getUploadPrefix(object $entity): string
    {
        return match (true) {
            $entity instanceof Page => 'page',
            $entity instanceof Event => 'actualite',
            $entity instanceof GalleryImage => 'galerie',
            $entity instanceof PageMedia => 'page-media',
            $entity instanceof CommunityOrganization => 'association',
            $entity instanceof SocialLink => 'reseau',
            $entity instanceof SiteSetting => 'parametre',
            default => 'image',
        };
    }

    private function isHomepageSetting(string $key): bool
    {
        return str_starts_with($key, 'hero_')
            || str_starts_with($key, 'home_')
            || str_starts_with($key, 'nav_')
            || str_starts_with($key, 'brand_')
            || str_starts_with($key, 'read_more_')
            || str_starts_with($key, 'source_label_')
            || str_starts_with($key, 'news_source_label_')
            || str_starts_with($key, 'planned_label_')
            || str_starts_with($key, 'no_news_');
    }

    private function isImageSetting(SiteSetting $setting): bool
    {
        return str_contains(strtolower($setting->getSettingKey()), 'image');
    }

    /**
     * @return array{section: string, title: string, hint: string, backRoute: string}
     */
    private function getFormContext(object $entity): array
    {
        return match (true) {
            $entity instanceof Page => [
                'section' => 'Pages',
                'title' => $entity->getId() ? 'Modifier une page' : 'Nouvelle page',
                'hint' => 'Titre, résumé, contenu multilingue, image principale, médiathèque et statut de publication.',
                'backRoute' => 'admin_dashboard',
            ],
            $entity instanceof PageMedia => [
                'section' => 'Médiathèque de page',
                'title' => $entity->getId() ? 'Modifier une image de page' : 'Nouvelle image de page',
                'hint' => 'Image attachée à une page, avec titre, légende et ordre.',
                'backRoute' => 'admin_page_edit',
                'backParams' => ['id' => $entity->getPage()?->getId()],
            ],
            $entity instanceof GalleryImage => [
                'section' => 'Médiathèque',
                'title' => $entity->getId() ? 'Modifier une image' : 'Nouvelle image',
                'hint' => 'Images WebP, crédit, source et mise en avant sur les pages publiques.',
                'backRoute' => 'admin_dashboard',
            ],
            $entity instanceof CommunityOrganization => [
                'section' => 'Associations',
                'title' => $entity->getId() ? 'Modifier une structure' : 'Nouvelle structure',
                'hint' => 'Fiche visible sur le site: nom, type, description, lien et image.',
                'backRoute' => 'admin_dashboard',
            ],
            $entity instanceof SocialLink => [
                'section' => 'Réseaux sociaux',
                'title' => $entity->getId() ? 'Modifier un lien social' : 'Nouveau lien social',
                'hint' => 'Lien, plateforme, catégorie, résumé et image associée.',
                'backRoute' => 'admin_dashboard',
            ],
            $entity instanceof Event => [
                'section' => 'Actualités',
                'title' => $entity->getId() ? 'Modifier une actualité' : 'Nouvelle actualité',
                'hint' => 'Date, lieu, catégorie, contenu multilingue et publication.',
                'backRoute' => 'admin_dashboard',
            ],
            $entity instanceof SiteSetting => [
                'section' => 'Paramètres',
                'title' => $entity->getId() ? 'Modifier un paramètre' : 'Nouveau paramètre',
                'hint' => 'Référencement, images globales, textes du pied de page et réglages éditoriaux.',
                'backRoute' => 'admin_settings',
            ],
            default => [
                'section' => 'CMS',
                'title' => 'Édition',
                'hint' => 'Modifiez le contenu puis enregistrez.',
                'backRoute' => 'admin_dashboard',
            ],
        };
    }
}
