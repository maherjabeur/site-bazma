<?php

namespace App\Entity;

use App\Repository\ContentApprovalRequestRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContentApprovalRequestRepository::class)]
class ContentApprovalRequest
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private string $action = 'update';

    #[ORM\Column(length: 160)]
    private string $entityClass = '';

    #[ORM\Column(nullable: true)]
    private ?int $entityId = null;

    #[ORM\Column(length: 180)]
    private string $entityLabel = '';

    #[ORM\Column(type: Types::JSON)]
    private array $payload = [];

    #[ORM\Column(length: 20)]
    private string $status = self::STATUS_PENDING;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    private ?AdminUser $requestedBy = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    private ?AdminUser $reviewedBy = null;

    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $reviewedAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int { return $this->id; }
    public function getAction(): string { return $this->action; }
    public function setAction(string $action): self { $this->action = $action; return $this; }
    public function getEntityClass(): string { return $this->entityClass; }
    public function setEntityClass(string $entityClass): self { $this->entityClass = $entityClass; return $this; }
    public function getEntityId(): ?int { return $this->entityId; }
    public function setEntityId(?int $entityId): self { $this->entityId = $entityId; return $this; }
    public function getEntityLabel(): string { return $this->entityLabel; }
    public function setEntityLabel(string $entityLabel): self { $this->entityLabel = mb_substr($entityLabel, 0, 180); return $this; }
    public function getPayload(): array { return $this->payload; }
    public function setPayload(array $payload): self { $this->payload = $payload; return $this; }
    public function getStatus(): string { return $this->status; }
    public function setStatus(string $status): self { $this->status = $status; return $this; }
    public function getRequestedBy(): ?AdminUser { return $this->requestedBy; }
    public function setRequestedBy(?AdminUser $requestedBy): self { $this->requestedBy = $requestedBy; return $this; }
    public function getReviewedBy(): ?AdminUser { return $this->reviewedBy; }
    public function setReviewedBy(?AdminUser $reviewedBy): self { $this->reviewedBy = $reviewedBy; return $this; }
    public function getCreatedAt(): \DateTimeImmutable { return $this->createdAt; }
    public function setCreatedAt(\DateTimeImmutable $createdAt): self { $this->createdAt = $createdAt; return $this; }
    public function getReviewedAt(): ?\DateTimeImmutable { return $this->reviewedAt; }
    public function setReviewedAt(?\DateTimeImmutable $reviewedAt): self { $this->reviewedAt = $reviewedAt; return $this; }
    public function isPending(): bool { return $this->status === self::STATUS_PENDING; }
}
