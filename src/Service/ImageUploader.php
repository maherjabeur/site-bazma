<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageUploader
{
    private const MAX_UPLOAD_SIZE = 8_388_608;
    private const MAX_VIDEO_SIZE = 67_108_864;
    private const VIDEO_EXTENSIONS = ['mp4', 'webm', 'mov'];

    public function __construct(private readonly string $projectDir)
    {
    }

    public function uploadAsWebp(UploadedFile $file, string $prefix = 'image', ?int $maxWidth = null, ?int $maxHeight = null): string
    {
        if (!$file->isValid()) {
            throw new \InvalidArgumentException('Le fichier envoyé est invalide.');
        }

        if ($file->getSize() !== null && $file->getSize() > self::MAX_UPLOAD_SIZE) {
            throw new \InvalidArgumentException('Image trop lourde. Maximum autorisé: 8 Mo.');
        }

        $type = $this->detectImageType($file->getPathname());
        if (!in_array($type, [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_WEBP], true)) {
            throw new \InvalidArgumentException('Format image non supporté. Utilisez JPG, PNG ou WebP.');
        }

        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) ?: $prefix;
        $safeName = $this->safeName($prefix.'-'.$originalName);
        $filename = $safeName.'-'.bin2hex(random_bytes(5)).'.webp';

        return $this->convertFileToWebp($file->getPathname(), '/uploads/'.$filename, $type, $maxWidth, $maxHeight);
    }

    public function uploadVideo(UploadedFile $file, string $prefix = 'video'): string
    {
        if (!$file->isValid()) {
            throw new \InvalidArgumentException('Le fichier envoyé est invalide.');
        }

        if ($file->getSize() !== null && $file->getSize() > self::MAX_VIDEO_SIZE) {
            throw new \InvalidArgumentException('Video trop lourde. Maximum autorise: 64 Mo.');
        }

        $extension = strtolower($file->getClientOriginalExtension() ?: pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION));
        if (!in_array($extension, self::VIDEO_EXTENSIONS, true)) {
            throw new \InvalidArgumentException('Format video non supporte. Utilisez MP4, WebM ou MOV.');
        }

        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) ?: $prefix;
        $safeName = $this->safeName($prefix.'-'.$originalName);
        $filename = $safeName.'-'.bin2hex(random_bytes(5)).'.'.$extension;
        $targetDir = $this->projectDir.'/public/uploads/videos';

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0775, true);
        }

        $file->move($targetDir, $filename);

        return '/uploads/videos/'.$filename;
    }

    public function uploadVideoFromPath(string $sourcePath, string $originalName, string $prefix = 'video'): string
    {
        if (!is_file($sourcePath)) {
            throw new \InvalidArgumentException('Video introuvable apres upload.');
        }

        $size = filesize($sourcePath);
        if ($size !== false && $size > self::MAX_VIDEO_SIZE) {
            throw new \InvalidArgumentException('Video trop lourde. Maximum autorise: 64 Mo.');
        }

        $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        if (!in_array($extension, self::VIDEO_EXTENSIONS, true)) {
            throw new \InvalidArgumentException('Format video non supporte. Utilisez MP4, WebM ou MOV.');
        }

        $originalBaseName = pathinfo($originalName, PATHINFO_FILENAME) ?: $prefix;
        $safeName = $this->safeName($prefix.'-'.$originalBaseName);
        $filename = $safeName.'-'.bin2hex(random_bytes(5)).'.'.$extension;
        $targetDir = $this->projectDir.'/public/uploads/videos';

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0775, true);
        }

        $targetPath = $targetDir.DIRECTORY_SEPARATOR.$filename;
        if (!rename($sourcePath, $targetPath)) {
            if (!copy($sourcePath, $targetPath)) {
                throw new \RuntimeException('Impossible de finaliser la video.');
            }
            unlink($sourcePath);
        }

        return '/uploads/videos/'.$filename;
    }

    public function normalizeLocalImagePath(?string $path): ?string
    {
        if (!$path) {
            return $path;
        }

        $path = trim($path);
        $urlPath = parse_url($path, PHP_URL_PATH);
        if (!$urlPath || str_ends_with(strtolower($urlPath), '.webp')) {
            return $path;
        }

        if (!str_starts_with($urlPath, '/assets/') && !str_starts_with($urlPath, '/uploads/')) {
            return $path;
        }

        if (!preg_match('/\.(png|jpe?g)$/i', $urlPath)) {
            return $path;
        }

        $sourcePath = $this->projectDir.'/public'.str_replace('/', DIRECTORY_SEPARATOR, $urlPath);
        if (!is_file($sourcePath)) {
            return $path;
        }

        $type = $this->detectImageType($sourcePath);
        if (!in_array($type, [IMAGETYPE_JPEG, IMAGETYPE_PNG], true)) {
            return $path;
        }

        $webpPath = (string) preg_replace('/\.(png|jpe?g)$/i', '.webp', $urlPath);
        $this->convertFileToWebp($sourcePath, $webpPath, $type);

        return $webpPath;
    }

    public function normalizeUploadPath(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        $path = trim(html_entity_decode($path, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
        if ($path === '') {
            return null;
        }

        $urlPath = parse_url($path, PHP_URL_PATH);
        if (!$urlPath) {
            return null;
        }

        $urlPath = rawurldecode($urlPath);
        if (!str_starts_with($urlPath, '/uploads/')) {
            return null;
        }

        return $urlPath;
    }

    public function deleteUploadedFile(?string $path): bool
    {
        $urlPath = $this->normalizeUploadPath($path);
        if (!$urlPath) {
            return false;
        }

        $uploadsRoot = realpath($this->projectDir.'/public/uploads');
        if (!$uploadsRoot) {
            return false;
        }

        $targetPath = $this->projectDir.'/public'.str_replace('/', DIRECTORY_SEPARATOR, $urlPath);
        $realTargetPath = realpath($targetPath);
        if (!$realTargetPath || !is_file($realTargetPath)) {
            return false;
        }

        $uploadsRoot = rtrim($uploadsRoot, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
        if (!str_starts_with($realTargetPath, $uploadsRoot)) {
            return false;
        }

        return @unlink($realTargetPath);
    }

    private function convertFileToWebp(string $sourcePath, string $publicTargetPath, int $type, ?int $maxWidth = null, ?int $maxHeight = null): string
    {
        $targetPath = $this->projectDir.'/public'.str_replace('/', DIRECTORY_SEPARATOR, $publicTargetPath);
        $targetDir = dirname($targetPath);
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0775, true);
        }

        $image = match ($type) {
            IMAGETYPE_JPEG => imagecreatefromjpeg($sourcePath),
            IMAGETYPE_PNG => $this->createFromPng($sourcePath),
            IMAGETYPE_WEBP => imagecreatefromwebp($sourcePath),
            default => false,
        };

        if (!$image instanceof \GdImage) {
            throw new \RuntimeException('Impossible de lire cette image.');
        }

        imagepalettetotruecolor($image);
        imagealphablending($image, true);
        imagesavealpha($image, true);

        $image = $this->resizeImage($image, $maxWidth, $maxHeight);

        if (!imagewebp($image, $targetPath, 84)) {
            imagedestroy($image);
            throw new \RuntimeException('Impossible de convertir cette image en WebP.');
        }

        imagedestroy($image);

        return $publicTargetPath;
    }

    private function resizeImage(\GdImage $image, ?int $maxWidth, ?int $maxHeight): \GdImage
    {
        $maxWidth = $maxWidth && $maxWidth > 0 ? min($maxWidth, 3200) : null;
        $maxHeight = $maxHeight && $maxHeight > 0 ? min($maxHeight, 3200) : null;

        if (!$maxWidth && !$maxHeight) {
            return $image;
        }

        $width = imagesx($image);
        $height = imagesy($image);
        $ratio = min($maxWidth ? $maxWidth / $width : 1, $maxHeight ? $maxHeight / $height : 1, 1);

        if ($ratio >= 1) {
            return $image;
        }

        $targetWidth = max(1, (int) round($width * $ratio));
        $targetHeight = max(1, (int) round($height * $ratio));
        $resized = imagecreatetruecolor($targetWidth, $targetHeight);

        imagealphablending($resized, false);
        imagesavealpha($resized, true);
        imagecopyresampled($resized, $image, 0, 0, 0, 0, $targetWidth, $targetHeight, $width, $height);
        imagedestroy($image);

        return $resized;
    }

    private function createFromPng(string $path): \GdImage|false
    {
        $image = imagecreatefrompng($path);
        if (!$image instanceof \GdImage) {
            return false;
        }

        imagepalettetotruecolor($image);
        imagealphablending($image, true);
        imagesavealpha($image, true);

        return $image;
    }

    private function safeName(string $name): string
    {
        $name = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $name) ?: $name;
        $name = strtolower((string) preg_replace('/[^a-zA-Z0-9]+/', '-', $name));
        $name = trim($name, '-');

        return $name !== '' ? $name : 'image';
    }

    private function detectImageType(string $path): ?int
    {
        $info = @getimagesize($path);

        return is_array($info) ? ($info[2] ?? null) : null;
    }
}
