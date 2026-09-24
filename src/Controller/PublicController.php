<?php

namespace App\Controller;

use App\Entity\GalleryImage;
use App\Entity\Page;
use App\Repository\CommunityOrganizationRepository;
use App\Repository\AdminUserRepository;
use App\Repository\EventRepository;
use App\Repository\GalleryImageRepository;
use App\Repository\PageMediaRepository;
use App\Repository\PageRepository;
use App\Repository\SiteSettingRepository;
use App\Repository\SocialLinkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PublicController extends AbstractController
{
    #[Route('/healthz', name: 'app_healthz')]
    public function healthz(): Response
    {
        return new Response('ok', Response::HTTP_OK, ['Content-Type' => 'text/plain; charset=UTF-8']);
    }

    #[Route('/', name: 'app_root')]
    public function root(): RedirectResponse
    {
        return $this->redirectToRoute('app_home', ['_locale' => 'ar']);
    }

    #[Route('/{_locale}', name: 'app_home', requirements: ['_locale' => 'ar|fr|en'])]
    public function home(Request $request, PageRepository $pages, GalleryImageRepository $images, EventRepository $events, SiteSettingRepository $settings, SocialLinkRepository $socialLinks, CommunityOrganizationRepository $organizations, AdminUserRepository $adminUsers): Response
    {
        $locale = $request->getLocale();

        return $this->render('public/home.html.twig', [
            'locale' => $locale,
            'pages' => $pages->findPublishedForHome(),
            'images' => $this->getPublicGalleryImages($images, 8),
            'events' => $events->findHomepageSlider(),
            'socialLinks' => $socialLinks->findBy(['featured' => true], ['position' => 'ASC'], 8),
            'organizations' => $organizations->findBy(['active' => true], ['position' => 'ASC']),
            'teamMembers' => $adminUsers->findPublicTeam(),
            'settings' => $settings,
        ]);
    }

    #[Route('/{_locale}/page/{slug}', name: 'app_page', requirements: ['_locale' => 'ar|fr|en'])]
    public function page(Request $request, string $slug, PageRepository $pages, PageMediaRepository $media): Response
    {
        if ($slug === Page::DONATION_SLUG) {
            throw $this->createNotFoundException('Page introuvable');
        }

        $page = $pages->findOneBy(['slug' => $slug, 'published' => true]);
        if (!$page) {
            throw $this->createNotFoundException('Page introuvable');
        }

        return $this->render('public/page.html.twig', [
            'locale' => $request->getLocale(),
            'page' => $page,
            'media' => $media->findForPage($page),
        ]);
    }

    #[Route('/{_locale}/actualites/{slug}', name: 'app_news_show', requirements: ['_locale' => 'ar|fr|en'])]
    public function newsShow(Request $request, string $slug, EventRepository $events): Response
    {
        $event = $events->findPublicBySlug($slug);
        if (!$event) {
            throw $this->createNotFoundException('Actualité introuvable');
        }

        return $this->render('public/news.html.twig', [
            'locale' => $request->getLocale(),
            'event' => $event,
        ]);
    }

    #[Route('/{_locale}/gallery', name: 'app_gallery', requirements: ['_locale' => 'ar|fr|en'])]
    public function gallery(Request $request, GalleryImageRepository $images): Response
    {
        $galleryImages = $this->getPublicGalleryImages($images);

        return $this->render('public/gallery.html.twig', [
            'locale' => $request->getLocale(),
            'images' => $galleryImages,
            'featuredImage' => $galleryImages[0] ?? null,
        ]);
    }

    /**
     * @return list<GalleryImage>
     */
    private function getPublicGalleryImages(GalleryImageRepository $images, ?int $limit = null): array
    {
        $galleryImages = array_values(array_filter(
            $images->findBy([], ['featured' => 'DESC', 'position' => 'ASC']),
            fn (GalleryImage $image): bool => $this->isLocalPublicImage($image->getImageUrl())
        ));

        return $limit ? array_slice($galleryImages, 0, $limit) : $galleryImages;
    }

    private function isLocalPublicImage(?string $url): bool
    {
        if (!$url) {
            return false;
        }

        $url = trim($url);

        return str_starts_with($url, '/uploads/') || str_starts_with($url, '/assets/');
    }

    #[Route('/robots.txt', name: 'app_robots', format: 'txt')]
    public function robots(): Response
    {
        $content = "User-agent: *\nAllow: /\nDisallow: /admin\nDisallow: /login\nSitemap: ".$this->generateUrl('app_sitemap', [], UrlGeneratorInterface::ABSOLUTE_URL)."\n";

        return new Response($content, 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
    }

    #[Route('/sitemap.xml', name: 'app_sitemap', format: 'xml')]
    public function sitemap(PageRepository $pages, EventRepository $events): Response
    {
        $entries = [];
        foreach (['ar', 'fr', 'en'] as $locale) {
            $this->addSitemapEntry($entries, 'app_home', ['_locale' => $locale], 'daily', '1.0');
            $this->addSitemapEntry($entries, 'app_gallery', ['_locale' => $locale], 'weekly', '0.7');
            foreach ($events->findPublishedActive() as $event) {
                $this->addSitemapEntry(
                    $entries,
                    'app_news_show',
                    ['_locale' => $locale, 'slug' => $event->getSlug()],
                    'weekly',
                    '0.8',
                    $event->getEventDate()
                );
            }
            foreach ($pages->findPublished() as $page) {
                if ($page->isSystemPage()) {
                    continue;
                }
                $this->addSitemapEntry(
                    $entries,
                    'app_page',
                    ['_locale' => $locale, 'slug' => $page->getSlug()],
                    'monthly',
                    '0.7'
                );
            }
        }

        $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        $xml .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\" xmlns:xhtml=\"http://www.w3.org/1999/xhtml\">\n";
        foreach ($entries as $entry) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>".$this->escapeXml($entry['url'])."</loc>\n";
            foreach ($entry['alternates'] as $language => $alternateUrl) {
                $xml .= "    <xhtml:link rel=\"alternate\" hreflang=\"".$this->escapeXml($language)."\" href=\"".$this->escapeXml($alternateUrl)."\" />\n";
            }
            if ($entry['lastmod']) {
                $xml .= "    <lastmod>".$this->escapeXml($entry['lastmod'])."</lastmod>\n";
            }
            $xml .= "    <changefreq>".$this->escapeXml($entry['changefreq'])."</changefreq>\n";
            $xml .= "    <priority>".$this->escapeXml($entry['priority'])."</priority>\n";
            $xml .= "  </url>\n";
        }
        $xml .= "</urlset>\n";

        return new Response($xml, 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }

    /**
     * @param array<string, array{url: string, alternates: array<string, string>, lastmod: ?string, changefreq: string, priority: string}> $entries
     * @param array<string, string> $parameters
     */
    private function addSitemapEntry(array &$entries, string $route, array $parameters, string $changefreq, string $priority, ?\DateTimeInterface $lastmod = null): void
    {
        $url = $this->generateUrl($route, $parameters, UrlGeneratorInterface::ABSOLUTE_URL);
        if (isset($entries[$url])) {
            return;
        }

        $alternates = [];
        foreach (['ar', 'fr', 'en'] as $language) {
            $alternates[$language] = $this->generateUrl(
                $route,
                array_replace($parameters, ['_locale' => $language]),
                UrlGeneratorInterface::ABSOLUTE_URL
            );
        }
        $alternates['x-default'] = $alternates['ar'];

        $entries[$url] = [
            'url' => $url,
            'alternates' => $alternates,
            'lastmod' => $lastmod?->format('Y-m-d'),
            'changefreq' => $changefreq,
            'priority' => $priority,
        ];
    }

    private function escapeXml(string $value): string
    {
        return htmlspecialchars($value, ENT_XML1 | ENT_QUOTES, 'UTF-8');
    }
}
