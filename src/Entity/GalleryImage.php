<?php

namespace App\Entity;

use App\Repository\GalleryImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GalleryImageRepository::class)]
class GalleryImage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 160)]
    private string $title = '';

    #[ORM\Column(length: 160, nullable: true)]
    private ?string $titleEn = null;

    #[ORM\Column(length: 160, nullable: true)]
    private ?string $titleAr = null;

    #[ORM\Column(length: 255)]
    private string $imageUrl = '';

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $credit = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sourceUrl = null;

    #[ORM\Column]
    private bool $featured = false;

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
    public function getImageUrl(): string { return $this->imageUrl; }
    public function setImageUrl(string $imageUrl): self { $this->imageUrl = $imageUrl; return $this; }
    public function getCredit(): ?string { return $this->credit; }
    public function setCredit(?string $credit): self { $this->credit = $credit; return $this; }
    public function getSourceUrl(): ?string { return $this->sourceUrl; }
    public function setSourceUrl(?string $sourceUrl): self { $this->sourceUrl = $sourceUrl; return $this; }
    public function isFeatured(): bool { return $this->featured; }
    public function setFeatured(bool $featured): self { $this->featured = $featured; return $this; }
    public function getPosition(): int { return $this->position; }
    public function setPosition(int $position): self { $this->position = $position; return $this; }
}
