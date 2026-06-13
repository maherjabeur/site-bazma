<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class ImageExtension extends AbstractExtension
{
    public function __construct(private readonly string $projectDir)
    {
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('webp_image', $this->webpImage(...)),
        ];
    }

    public function webpImage(?string $url): string
    {
        if (!$url) {
            return '';
        }

        $path = parse_url($url, PHP_URL_PATH);
        if (!$path || str_ends_with(strtolower($path), '.webp')) {
            return $url;
        }

        if (!str_starts_with($path, '/assets/') && !str_starts_with($path, '/uploads/')) {
            return $url;
        }

        $webpPath = preg_replace('/\.(png|jpe?g)$/i', '.webp', $path);
        if (!$webpPath || $webpPath === $path) {
            return $url;
        }

        $absoluteWebpPath = $this->projectDir . '/public' . str_replace('/', DIRECTORY_SEPARATOR, $webpPath);
        if (is_file($absoluteWebpPath)) {
            return $webpPath;
        }

        $absoluteSourcePath = $this->projectDir . '/public' . str_replace('/', DIRECTORY_SEPARATOR, $path);
        if (is_file($absoluteSourcePath) && $this->createWebp($absoluteSourcePath, $absoluteWebpPath)) {
            return $webpPath;
        }

        return $url;
    }

    private function createWebp(string $sourcePath, string $targetPath): bool
    {
        $extension = strtolower(pathinfo($sourcePath, PATHINFO_EXTENSION));
        $image = match ($extension) {
            'jpg', 'jpeg' => imagecreatefromjpeg($sourcePath),
            'png' => imagecreatefrompng($sourcePath),
            default => false,
        };

        if (!$image instanceof \GdImage) {
            return false;
        }

        $targetDir = dirname($targetPath);
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0775, true);
        }

        imagepalettetotruecolor($image);
        imagealphablending($image, true);
        imagesavealpha($image, true);
        $created = imagewebp($image, $targetPath, 84);
        imagedestroy($image);

        return $created;
    }
}
