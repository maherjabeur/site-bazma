<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class ContentExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('rich_content', $this->richContent(...), ['is_safe' => ['html']]),
        ];
    }

    public function richContent(?string $content): string
    {
        if (!$content) {
            return '';
        }

        if (!preg_match('/<[a-z][\s\S]*>/i', $content)) {
            return nl2br(htmlspecialchars($content, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'));
        }

        $allowedTags = '<p><br><strong><b><em><i><u><h2><h3><h4><ul><ol><li><blockquote><a><figure><figcaption><img><video><source>';
        $html = strip_tags($content, $allowedTags);
        $html = preg_replace('/\s+on[a-z]+\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)/i', '', $html) ?? $html;
        $html = preg_replace('/href\s*=\s*([\'"])\s*javascript:[^\'"]*\1/i', 'href="#"', $html) ?? $html;
        $html = preg_replace('/src\s*=\s*([\'"])\s*javascript:[^\'"]*\1/i', 'src=""', $html) ?? $html;
        $html = preg_replace('/\sstyle\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)/i', '', $html) ?? $html;

        return $html;
    }
}
