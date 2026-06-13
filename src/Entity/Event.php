<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 160)]
    private string $title = '';

    #[ORM\Column(length: 170, unique: true)]
    private string $slug = '';

    #[ORM\Column(length: 160, nullable: true)]
    private ?string $titleEn = null;

    #[ORM\Column(length: 160, nullable: true)]
    private ?string $titleAr = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $eventDate = null;

    #[ORM\Column(length: 255)]
    private string $location = 'Bazma, Kebili';

    #[ORM\Column(length: 80)]
    private string $category = 'Actualite';

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sourceUrl = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageUrl = null;

    #[ORM\Column(length: 220, nullable: true)]
    private ?string $excerpt = null;

    #[ORM\Column(length: 220, nullable: true)]
    private ?string $excerptEn = null;

    #[ORM\Column(length: 220, nullable: true)]
    private ?string $excerptAr = null;

    #[ORM\Column]
    private bool $featured = true;

    #[ORM\Column]
    private int $position = 0;

    #[ORM\Column(type: Types::TEXT)]
    private string $description = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descriptionEn = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descriptionAr = null;

    #[ORM\Column]
    private bool $published = true;

    public function getId(): ?int { return $this->id; }
    public function getTitle(): string { return $this->title; }
    public function setTitle(string $title): self { $this->title = $title; return $this; }
    public function getSlug(): string { return $this->slug; }
    public function setSlug(string $slug): self { $this->slug = $slug; return $this; }
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
    public function getEventDate(): ?\DateTimeInterface { return $this->eventDate; }
    public function setEventDate(?\DateTimeInterface $eventDate): self { $this->eventDate = $eventDate; return $this; }
    public function getLocation(): string { return $this->location; }
    public function setLocation(string $location): self { $this->location = $location; return $this; }
    public function getCategory(): string { return $this->category; }
    public function setCategory(string $category): self { $this->category = $category; return $this; }
    public function getSourceUrl(): ?string { return $this->sourceUrl; }
    public function setSourceUrl(?string $sourceUrl): self { $this->sourceUrl = $sourceUrl; return $this; }
    public function getImageUrl(): ?string { return $this->imageUrl; }
    public function setImageUrl(?string $imageUrl): self { $this->imageUrl = $imageUrl; return $this; }
    public function getExcerpt(): ?string { return $this->excerpt; }
    public function setExcerpt(?string $excerpt): self { $this->excerpt = $excerpt; return $this; }
    public function getExcerptEn(): ?string { return $this->excerptEn; }
    public function setExcerptEn(?string $excerptEn): self { $this->excerptEn = $excerptEn; return $this; }
    public function getExcerptAr(): ?string { return $this->excerptAr; }
    public function setExcerptAr(?string $excerptAr): self { $this->excerptAr = $excerptAr; return $this; }
    public function localizedExcerpt(string $locale): string
    {
        $excerpt = match ($locale) {
            'ar' => $this->excerptAr ?: $this->excerpt,
            'en' => $this->excerptEn ?: $this->excerpt,
            default => $this->excerpt,
        };

        return $excerpt ?: mb_substr(strip_tags($this->localizedDescription($locale)), 0, 180);
    }
    public function isFeatured(): bool { return $this->featured; }
    public function setFeatured(bool $featured): self { $this->featured = $featured; return $this; }
    public function getPosition(): int { return $this->position; }
    public function setPosition(int $position): self { $this->position = $position; return $this; }
    public function getDescription(): string { return $this->description; }
    public function setDescription(string $description): self { $this->description = $description; return $this; }
    public function getDescriptionEn(): ?string { return $this->descriptionEn; }
    public function setDescriptionEn(?string $descriptionEn): self { $this->descriptionEn = $descriptionEn; return $this; }
    public function getDescriptionAr(): ?string { return $this->descriptionAr; }
    public function setDescriptionAr(?string $descriptionAr): self { $this->descriptionAr = $descriptionAr; return $this; }
    public function localizedDescription(string $locale): string
    {
        return match ($locale) {
            'ar' => $this->descriptionAr ?: $this->description,
            'en' => $this->descriptionEn ?: $this->description,
            default => $this->description,
        };
    }
    public function isPublished(): bool { return $this->published; }
    public function setPublished(bool $published): self { $this->published = $published; return $this; }
}
