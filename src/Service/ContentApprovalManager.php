<?php

namespace App\Service;

use App\Entity\AdminUser;
use App\Entity\CommunityOrganization;
use App\Entity\ContentApprovalRequest;
use App\Entity\Event;
use App\Entity\GalleryImage;
use App\Entity\Page;
use App\Entity\PageMedia;
use App\Entity\SiteSetting;
use App\Entity\SocialLink;
use Doctrine\ORM\EntityManagerInterface;

class ContentApprovalManager
{
    private const ACTION_CREATE = 'create';
    private const ACTION_UPDATE = 'update';
    private const ACTION_DELETE = 'delete';
    private const ACTION_SETTINGS_GROUP = 'settings_group';

    private const FIELDS = [
        Page::class => ['title', 'titleEn', 'titleAr', 'slug', 'summary', 'summaryEn', 'summaryAr', 'body', 'bodyEn', 'bodyAr', 'imageUrl', 'published', 'position'],
        PageMedia::class => ['page', 'title', 'imageUrl', 'caption', 'position'],
        GalleryImage::class => ['title', 'titleEn', 'titleAr', 'imageUrl', 'credit', 'sourceUrl', 'featured', 'position'],
        Event::class => ['title', 'slug', 'titleEn', 'titleAr', 'eventDate', 'location', 'category', 'sourceUrl', 'imageUrl', 'excerpt', 'excerptEn', 'excerptAr', 'featured', 'archived', 'position', 'description', 'descriptionEn', 'descriptionAr', 'published'],
        CommunityOrganization::class => ['name', 'nameEn', 'nameAr', 'type', 'description', 'descriptionEn', 'descriptionAr', 'url', 'imageUrl', 'active', 'position'],
        SocialLink::class => ['platform', 'category', 'title', 'titleEn', 'titleAr', 'summary', 'summaryEn', 'summaryAr', 'url', 'imageUrl', 'position', 'featured'],
        SiteSetting::class => ['settingKey', 'settingValue'],
    ];

    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    public function createEntityRequest(object $entity, ?AdminUser $user): ContentApprovalRequest
    {
        return $this->buildRequest($entity, self::ACTION_CREATE, $user);
    }

    public function updateEntityRequest(object $entity, ?AdminUser $user): ContentApprovalRequest
    {
        return $this->buildRequest($entity, self::ACTION_UPDATE, $user);
    }

    public function deleteEntityRequest(object $entity, ?AdminUser $user): ContentApprovalRequest
    {
        $request = $this->buildRequest($entity, self::ACTION_DELETE, $user);
        $request->setPayload([]);

        return $request;
    }

    /**
     * @param array<string, string> $settings
     */
    public function settingsGroupRequest(array $settings, ?AdminUser $user): ContentApprovalRequest
    {
        return (new ContentApprovalRequest())
            ->setAction(self::ACTION_SETTINGS_GROUP)
            ->setEntityClass(SiteSetting::class)
            ->setEntityLabel('Parametres accueil')
            ->setPayload(['settings' => $settings])
            ->setRequestedBy($user);
    }

    public function approve(ContentApprovalRequest $request, AdminUser $reviewer): void
    {
        if (!$request->isPending()) {
            throw new \RuntimeException('Cette demande a deja ete traitee.');
        }

        match ($request->getAction()) {
            self::ACTION_CREATE => $this->applyCreate($request),
            self::ACTION_UPDATE => $this->applyUpdate($request),
            self::ACTION_DELETE => $this->applyDelete($request),
            self::ACTION_SETTINGS_GROUP => $this->applySettingsGroup($request),
            default => throw new \RuntimeException('Action de validation inconnue.'),
        };

        $request
            ->setStatus(ContentApprovalRequest::STATUS_APPROVED)
            ->setReviewedBy($reviewer)
            ->setReviewedAt(new \DateTimeImmutable());
    }

    public function reject(ContentApprovalRequest $request, AdminUser $reviewer): void
    {
        if (!$request->isPending()) {
            throw new \RuntimeException('Cette demande a deja ete traitee.');
        }

        $request
            ->setStatus(ContentApprovalRequest::STATUS_REJECTED)
            ->setReviewedBy($reviewer)
            ->setReviewedAt(new \DateTimeImmutable());
    }

    private function buildRequest(object $entity, string $action, ?AdminUser $user): ContentApprovalRequest
    {
        return (new ContentApprovalRequest())
            ->setAction($action)
            ->setEntityClass($entity::class)
            ->setEntityId($this->getEntityId($entity))
            ->setEntityLabel($this->getEntityLabel($entity))
            ->setPayload($this->snapshot($entity))
            ->setRequestedBy($user);
    }

    private function applyCreate(ContentApprovalRequest $request): void
    {
        $class = $this->assertSupportedClass($request->getEntityClass());
        $entity = new $class();
        $this->applyPayload($entity, $request->getPayload());
        $this->em->persist($entity);
    }

    private function applyUpdate(ContentApprovalRequest $request): void
    {
        $entity = $this->findTarget($request);
        $this->applyPayload($entity, $request->getPayload());
    }

    private function applyDelete(ContentApprovalRequest $request): void
    {
        $entity = $this->findTarget($request);
        $this->em->remove($entity);
    }

    private function applySettingsGroup(ContentApprovalRequest $request): void
    {
        foreach (($request->getPayload()['settings'] ?? []) as $key => $value) {
            $setting = $this->em->getRepository(SiteSetting::class)->findOneBy(['settingKey' => $key]) ?? (new SiteSetting())->setSettingKey($key);
            $setting->setSettingValue((string) $value);
            $this->em->persist($setting);
        }
    }

    private function findTarget(ContentApprovalRequest $request): object
    {
        $class = $this->assertSupportedClass($request->getEntityClass());
        $id = $request->getEntityId();
        if (!$id) {
            throw new \RuntimeException('Element cible introuvable.');
        }

        return $this->em->find($class, $id) ?? throw new \RuntimeException('Element cible introuvable.');
    }

    /**
     * @return array<string, mixed>
     */
    private function snapshot(object $entity): array
    {
        $data = [];
        foreach (self::FIELDS[$entity::class] ?? [] as $field) {
            $getter = $this->getter($entity, $field);
            $value = $entity->$getter();
            if ($value instanceof \DateTimeInterface) {
                $value = $value->format('Y-m-d');
            } elseif ($value instanceof Page) {
                $value = $value->getId();
            }
            $data[$field] = $value;
        }

        return $data;
    }

    /**
     * @param array<string, mixed> $payload
     */
    private function applyPayload(object $entity, array $payload): void
    {
        foreach (self::FIELDS[$entity::class] ?? [] as $field) {
            if (!array_key_exists($field, $payload)) {
                continue;
            }

            $value = $payload[$field];
            if ($entity instanceof PageMedia && $field === 'page') {
                $value = $this->em->find(Page::class, (int) $value);
            } elseif ($entity instanceof Event && $field === 'eventDate') {
                $value = $value ? new \DateTimeImmutable((string) $value) : null;
            }

            $setter = 'set'.ucfirst($field);
            $entity->$setter($value);
        }
    }

    /**
     * @return class-string
     */
    private function assertSupportedClass(string $class): string
    {
        if (!array_key_exists($class, self::FIELDS)) {
            throw new \RuntimeException('Type de contenu non pris en charge.');
        }

        return $class;
    }

    private function getEntityId(object $entity): ?int
    {
        return method_exists($entity, 'getId') ? $entity->getId() : null;
    }

    private function getEntityLabel(object $entity): string
    {
        foreach (['getTitle', 'getName', 'getSettingKey', 'getPlatform'] as $getter) {
            if (method_exists($entity, $getter)) {
                return (string) $entity->$getter();
            }
        }

        return basename(str_replace('\\', '/', $entity::class));
    }

    private function getter(object $entity, string $field): string
    {
        $isGetter = 'is'.ucfirst($field);
        if (method_exists($entity, $isGetter)) {
            return $isGetter;
        }

        return 'get'.ucfirst($field);
    }
}
