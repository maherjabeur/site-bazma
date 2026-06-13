<?php

namespace App\Entity;

use App\Repository\CommunityOrganizationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommunityOrganizationRepository::class)]
class CommunityOrganization
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 160)]
    private string $name = '';

    #[ORM\Column(length: 160, nullable: true)]
    private ?string $nameEn = null;

    #[ORM\Column(length: 160, nullable: true)]
    private ?string $nameAr = null;

    #[ORM\Column(length: 80)]
    private string $type = 'Association';

    #[ORM\Column(type: Types::TEXT)]
    private string $description = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descriptionEn = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descriptionAr = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $url = null;

    #[ORM\Column(length: 255)]
    private string $imageUrl = '/assets/bazma-memory.webp';

    #[ORM\Column]
    private bool $active = true;

    #[ORM\Column]
    private int $position = 0;

    public function getId(): ?int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function setName(string $name): self { $this->name = $name; return $this; }
    public function getNameEn(): ?string { return $this->nameEn; }
    public function setNameEn(?string $nameEn): self { $this->nameEn = $nameEn; return $this; }
    public function getNameAr(): ?string { return $this->nameAr; }
    public function setNameAr(?string $nameAr): self { $this->nameAr = $nameAr; return $this; }
    public function localizedName(string $locale): string
    {
        return match ($locale) {
            'ar' => $this->nameAr ?: $this->name,
            'en' => $this->nameEn ?: $this->name,
            default => $this->name,
        };
    }
    public function getType(): string { return $this->type; }
    public function setType(string $type): self { $this->type = $type; return $this; }
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
    public function getUrl(): ?string { return $this->url; }
    public function setUrl(?string $url): self { $this->url = $url; return $this; }
    public function getImageUrl(): string { return $this->imageUrl; }
    public function setImageUrl(string $imageUrl): self { $this->imageUrl = $imageUrl; return $this; }
    public function isActive(): bool { return $this->active; }
    public function setActive(bool $active): self { $this->active = $active; return $this; }
    public function getPosition(): int { return $this->position; }
    public function setPosition(int $position): self { $this->position = $position; return $this; }
}
