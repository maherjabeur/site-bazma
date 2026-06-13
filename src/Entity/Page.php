<?php

namespace App\Entity;

use App\Repository\PageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PageRepository::class)]
class Page
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 120)]
    private string $title = '';

    #[ORM\Column(length: 120, nullable: true)]
    private ?string $titleEn = null;

    #[ORM\Column(length: 120, nullable: true)]
    private ?string $titleAr = null;

    #[ORM\Column(length: 140, unique: true)]
    private string $slug = '';

    #[ORM\Column(length: 180)]
    private string $summary = '';

    #[ORM\Column(length: 180, nullable: true)]
    private ?string $summaryEn = null;

    #[ORM\Column(length: 180, nullable: true)]
    private ?string $summaryAr = null;

    #[ORM\Column(type: Types::TEXT)]
    private string $body = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $bodyEn = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $bodyAr = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageUrl = null;

    #[ORM\Column]
    private bool $published = true;

    #[ORM\Column]
    private int $position = 0;

    public function getId(): ?int { return $this->id; }
    public function getTitle(): string { return $this->title; }
    public function setTitle(string $title): self { $this->title = $title; return $this; }
    public function getTitleEn(): ?string { return $this->titleEn; }
    public function setTitleEn(?string $titleEn): self { $this->titleEn = $titleEn; return $this; }
    public function getTitleAr(): ?string { return $this->titleAr; }
    public function setTitleAr(?string $titleAr): self { $this->titleAr = $titleAr; return $this; }
    public function localizedTitle(string $locale): string
    {
        return match ($locale) {
            'ar' => $this->titleAr ?: $this->title,
            'en' => $this->titleEn ?: $this->title,
            default => $this->title,
        };
    }
    public function getSlug(): string { return $this->slug; }
    public function setSlug(string $slug): self { $this->slug = $slug; return $this; }
    public function getSummary(): string { return $this->summary; }
    public function setSummary(string $summary): self { $this->summary = $summary; return $this; }
    public function getSummaryEn(): ?string { return $this->summaryEn; }
    public function setSummaryEn(?string $summaryEn): self { $this->summaryEn = $summaryEn; return $this; }
    public function getSummaryAr(): ?string { return $this->summaryAr; }
    public function setSummaryAr(?string $summaryAr): self { $this->summaryAr = $summaryAr; return $this; }
    public function localizedSummary(string $locale): string
    {
        return match ($locale) {
            'ar' => $this->summaryAr ?: $this->summary,
            'en' => $this->summaryEn ?: $this->summary,
            default => $this->summary,
        };
    }
    public function getBody(): string { return $this->body; }
    public function setBody(string $body): self { $this->body = $body; return $this; }
    public function getBodyEn(): ?string { return $this->bodyEn; }
    public function setBodyEn(?string $bodyEn): self { $this->bodyEn = $bodyEn; return $this; }
    public function getBodyAr(): ?string { return $this->bodyAr; }
    public function setBodyAr(?string $bodyAr): self { $this->bodyAr = $bodyAr; return $this; }
    public function localizedBody(string $locale): string
    {
        return match ($locale) {
            'ar' => $this->bodyAr ?: $this->body,
            'en' => $this->bodyEn ?: $this->body,
            default => $this->body,
        };
    }
    public function getImageUrl(): ?string { return $this->imageUrl; }
    public function setImageUrl(?string $imageUrl): self { $this->imageUrl = $imageUrl; return $this; }
    public function isPublished(): bool { return $this->published; }
    public function setPublished(bool $published): self { $this->published = $published; return $this; }
    public function getPosition(): int { return $this->position; }
    public function setPosition(int $position): self { $this->position = $position; return $this; }
}
