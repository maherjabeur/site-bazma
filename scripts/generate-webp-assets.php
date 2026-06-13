<?php

declare(strict_types=1);

$assetDir = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'assets';

function canvas(int $width = 1200, int $height = 860, string $bg = '#f7f4ec'): GdImage
{
    $image = imagecreatetruecolor($width, $height);
    imagealphablending($image, true);
    imagesavealpha($image, true);
    imagefilledrectangle($image, 0, 0, $width, $height, color($image, $bg));

    return $image;
}

function color(GdImage $image, string $hex, int $alpha = 0): int
{
    $hex = ltrim($hex, '#');
    return imagecolorallocatealpha(
        $image,
        hexdec(substr($hex, 0, 2)),
        hexdec(substr($hex, 2, 2)),
        hexdec(substr($hex, 4, 2)),
        $alpha
    );
}

function polygon(GdImage $image, array $points, string $hex): void
{
    imagefilledpolygon($image, $points, color($image, $hex));
}

function palm(GdImage $image, int $x, int $y, float $scale = 1): void
{
    $trunk = color($image, '#14342d');
    imagefilledrectangle($image, (int)($x - 12 * $scale), $y, (int)($x + 12 * $scale), (int)($y + 230 * $scale), $trunk);
    for ($i = 0; $i < 10; $i++) {
        $angle = deg2rad(-155 + $i * 34);
        $x2 = (int)($x + cos($angle) * 150 * $scale);
        $y2 = (int)($y + sin($angle) * 90 * $scale);
        imagesetthickness($image, (int)(18 * $scale));
        imageline($image, $x, $y, $x2, $y2, $trunk);
    }
    imagefilledellipse($image, $x, $y, (int)(34 * $scale), (int)(34 * $scale), $trunk);
}

function labelText(GdImage $image, string $text, int $x, int $y, int $size = 5, string $hex = '#13231d'): void
{
    imagestring($image, $size, $x, $y, $text, color($image, $hex));
}

function saveWebp(GdImage $image, string $name): void
{
    global $assetDir;
    imagewebp($image, $assetDir . DIRECTORY_SEPARATOR . $name, 88);
    imagedestroy($image);
}

function bazmaHero(): GdImage
{
    $im = canvas(1600, 950, '#e8a957');
    imagefilledellipse($im, 1220, 180, 180, 180, color($im, '#f8df91'));
    polygon($im, [0,600, 360,520, 690,570, 980,500, 1600,545, 1600,950, 0,950], '#0f6b56');
    polygon($im, [0,730, 390,685, 735,740, 1080,690, 1600,760, 1600,950, 0,950], '#14342d');
    palm($im, 360, 410, 1.2);
    palm($im, 1110, 450, .85);
    imagefilledrectangle($im, 675, 575, 880, 700, color($im, '#f7f0d6'));
    imagefilledrectangle($im, 720, 515, 840, 590, color($im, '#f7f0d6'));
    imagefilledrectangle($im, 930, 615, 1085, 700, color($im, '#f7f0d6'));
    labelText($im, 'BAZMA', 90, 120, 5, '#fff7dd');
    return $im;
}

function baseOasis(string $title): GdImage
{
    $im = canvas(1200, 860, '#f4d38a');
    polygon($im, [0,560, 320,470, 650,550, 1200,455, 1200,860, 0,860], '#0f6b56');
    polygon($im, [0,660, 380,610, 700,665, 1200,590, 1200,860, 0,860], '#183b32');
    palm($im, 555, 360, 1.05);
    labelText($im, $title, 58, 74, 5);
    return $im;
}

$assets = [
    'bazma-hero.webp' => bazmaHero(),
    'bazma-oasis.webp' => baseOasis('Bazma Oasis'),
    'bazma-youth.webp' => (function (): GdImage {
        $im = canvas(1200, 860, '#e7f1ed');
        imagefilledellipse($im, 915, 170, 175, 175, color($im, '#d99a3a'));
        imagefilledrectangle($im, 145, 310, 1055, 650, color($im, '#ffffff'));
        imagefilledrectangle($im, 215, 395, 380, 570, color($im, '#087c66'));
        imagefilledrectangle($im, 500, 395, 665, 570, color($im, '#9f5131'));
        imagefilledrectangle($im, 785, 395, 950, 570, color($im, '#13231d'));
        labelText($im, 'Bazma Youth Center', 95, 105, 5);
        return $im;
    })(),
    'bazma-horses.webp' => (function (): GdImage {
        $im = canvas(1200, 860, '#f2c46f');
        polygon($im, [0,575, 360,500, 650,565, 1200,510, 1200,860, 0,860], '#8b4b2c');
        polygon($im, [270,540, 630,540, 720,635, 840,635, 760,710, 610,710, 520,600, 360,600, 295,710, 200,710], '#13231d');
        imagefilledellipse($im, 765, 468, 90, 90, color($im, '#13231d'));
        labelText($im, 'Bazma Traditions', 75, 110, 5);
        return $im;
    })(),
    'bazma-sport.webp' => (function (): GdImage {
        $im = canvas(1200, 860, '#dfeef0');
        imagefilledrectangle($im, 110, 195, 1090, 700, color($im, '#0f7b63'));
        imagesetthickness($im, 10);
        imageline($im, 110, 447, 1090, 447, color($im, '#ffffff', 45));
        imageline($im, 600, 195, 600, 700, color($im, '#ffffff', 45));
        imageellipse($im, 600, 447, 210, 210, color($im, '#ffffff', 45));
        imagefilledellipse($im, 600, 447, 92, 92, color($im, '#f7f4ec'));
        labelText($im, 'Bazma Sport', 360, 105, 5);
        return $im;
    })(),
    'bazma-airport.webp' => (function (): GdImage {
        $im = canvas(1200, 860, '#cfe7ea');
        polygon($im, [0,570, 350,520, 650,545, 1200,565, 1200,860, 0,860], '#c99754');
        polygon($im, [260,480, 945,350, 1005,392, 720,550, 895,655, 830,690, 575,590, 380,695, 325,660, 455,535, 235,510], '#13231d');
        labelText($im, 'Airport Bazma', 95, 120, 5);
        return $im;
    })(),
    'bazma-memory.webp' => (function (): GdImage {
        $im = canvas(1200, 860, '#f7f4ec');
        imagefilledrectangle($im, 160, 160, 480, 595, color($im, '#ffffff'));
        imagefilledrectangle($im, 430, 135, 770, 610, color($im, '#ffffff'));
        imagefilledrectangle($im, 710, 185, 1030, 630, color($im, '#ffffff'));
        polygon($im, [170,450, 330,395, 510,455, 760,405, 1030,450, 1030,590, 170,590], '#087c66');
        labelText($im, 'Bazma Memory', 120, 735, 5);
        return $im;
    })(),
];

foreach ($assets as $name => $image) {
    saveWebp($image, $name);
    echo $name . PHP_EOL;
}
