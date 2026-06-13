<?php

namespace App\Entity;

use App\Repository\SiteSettingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SiteSettingRepository::class)]
class SiteSetting
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 80, unique: true)]
    private string $settingKey = '';

    #[ORM\Column(type: Types::TEXT)]
    private string $settingValue = '';

    public function getId(): ?int { return $this->id; }
    public function getSettingKey(): string { return $this->settingKey; }
    public function setSettingKey(string $settingKey): self { $this->settingKey = $settingKey; return $this; }
    public function getSettingValue(): string { return $this->settingValue; }
    public function setSettingValue(string $settingValue): self { $this->settingValue = $settingValue; return $this; }
}
