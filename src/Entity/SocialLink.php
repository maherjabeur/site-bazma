<?php

namespace App\Entity;

use App\Repository\SocialLinkRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SocialLinkRepository::class)]
class SocialLink
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 80)]
    private string $platform = 'Facebook';

    #[ORM\Column(length: 160)]
    private string $title = '';

    #[ORM\Column(length: 160, nullable: true)]
    private ?string $titleEn = null;

    #[ORM\Column(length: 160, nullable: true)]
    private ?string $titleAr = null;

    #[ORM\Column(type: Types::TEXT)]
    private string $summary = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $summaryEn = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $summaryAr = null;

    #[ORM\Column(length: 255)]
    private string $url = '';

    #[ORM\Column(length: 255)]
    private string $imageUrl = '';

    #[ORM\Column(length: 80)]
    private string $category = '';

    #[ORM\Column]
    private bool $featured = true;

    #[ORM\Column]
    private int $position = 0;

    public function getId(): ?int { return $this->id; }
    public function getPlatform(): string { return $this->platform; }
    public function setPlatform(string $platform): self { $this->platform = $platform; return $this; }
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
    public function getUrl(): string { return $this->url; }
    public function setUrl(string $url): self { $this->url = $url; return $this; }
    public function getImageUrl(): string { return $this->imageUrl; }
    public function setImageUrl(string $imageUrl): self { $this->imageUrl = $imageUrl; return $this; }
    public function getCategory(): string { return $this->category; }
    public function setCategory(string $category): self { $this->category = $category; return $this; }
    public function isFeatured(): bool { return $this->featured; }
    public function setFeatured(bool $featured): self { $this->featured = $featured; return $this; }
    public function getPosition(): int { return $this->position; }
    public function setPosition(int $position): self { $this->position = $position; return $this; }
}
