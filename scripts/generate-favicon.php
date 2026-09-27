<?php

declare(strict_types=1);

/**
 * Generates the raster companions to public/favicon.svg.
 * Run from the project root: php scripts/generate-favicon.php
 */

$publicDirectory = dirname(__DIR__) . '/public';

function createFavicon(int $size): GdImage
{
    $scale = 4;
    $canvasSize = $size * $scale;
    $image = imagecreatetruecolor($canvasSize, $canvasSize);
    imagealphablending($image, true);
    imagesavealpha($image, true);

    $transparent = imagecolorallocatealpha($image, 0, 0, 0, 127);
    $green = imagecolorallocate($image, 29, 52, 44);
    $sand = imagecolorallocate($image, 195, 149, 84);
    $cream = imagecolorallocate($image, 255, 250, 240);
    $gold = imagecolorallocate($image, 228, 189, 125);
    imagefill($image, 0, 0, $transparent);

    $s = static fn (float $value): int => (int) round($value * $size / 64 * $scale);

    // Oasis arch and rounded base.
    imagefilledellipse($image, $s(32), $s(31), $s(56), $s(58), $green);
    imagefilledrectangle($image, $s(4), $s(31), $s(60), $s(56), $green);
    imagefilledellipse($image, $s(10), $s(56), $s(12), $s(12), $green);
    imagefilledellipse($image, $s(54), $s(56), $s(12), $s(12), $green);
    imagefilledrectangle($image, $s(10), $s(50), $s(54), $s(62), $green);

    // A warm dune at the base.
    $dune = [4, 48, 14, 44, 25, 43, 34, 46, 44, 48, 52, 47, 60, 44, 60, 58, 56, 62, 8, 62, 4, 58];
    $dune = array_map($s, $dune);
    imagefilledpolygon($image, $dune, $sand);

    // Geometric B monogram, kept deliberately bold for 16 px rendering.
    imagesetthickness($image, max(1, $s(5)));
    imageline($image, $s(20), $s(15), $s(20), $s(48), $cream);
    imagearc($image, $s(32), $s(24), $s(24), $s(17), 270, 90, $cream);
    imageline($image, $s(20), $s(16), $s(32), $s(16), $cream);
    imageline($image, $s(20), $s(32), $s(33), $s(32), $cream);
    imagearc($image, $s(33), $s(40), $s(25), $s(16), 270, 90, $cream);
    imageline($image, $s(20), $s(48), $s(33), $s(48), $cream);
    imagefilledellipse($image, $s(49), $s(16), $s(6), $s(6), $gold);

    $output = imagecreatetruecolor($size, $size);
    imagealphablending($output, false);
    imagesavealpha($output, true);
    imagecopyresampled($output, $image, 0, 0, 0, 0, $size, $size, $canvasSize, $canvasSize);
    imagedestroy($image);

    return $output;
}

function pngBytes(GdImage $image): string
{
    ob_start();
    imagepng($image, null, 9);

    return (string) ob_get_clean();
}

$favicon32 = createFavicon(32);
$favicon32Bytes = pngBytes($favicon32);
file_put_contents($publicDirectory . '/favicon-32x32.png', $favicon32Bytes);
imagedestroy($favicon32);

$appleIcon = createFavicon(180);
imagepng($appleIcon, $publicDirectory . '/apple-touch-icon.png', 9);
imagedestroy($appleIcon);

$icoHeader = pack('vvv', 0, 1, 1);
$icoEntry = pack('CCCCvvVV', 32, 32, 0, 0, 1, 32, strlen($favicon32Bytes), 22);
file_put_contents($publicDirectory . '/favicon.ico', $icoHeader . $icoEntry . $favicon32Bytes);

echo "Generated favicon.ico, favicon-32x32.png and apple-touch-icon.png\n";
