<?php

namespace App\Service;

use Composer\CaBundle\CaBundle;
use Psr\Cache\CacheItemPoolInterface;

final class AutomaticTranslationService
{
    private const LANGUAGES = ['fr', 'en', 'ar'];

    public function __construct(
        private readonly CacheItemPoolInterface $cache,
        private readonly string $provider,
        private readonly string $endpoint,
        private readonly string $apiKey = '',
    ) {
    }

    /**
     * Completes the empty values of each multilingual group from the first
     * language supplied by the editor. Existing translations are preserved.
     *
     * @param array<string, array<string, string|null>> $groups
     * @return array{groups: array<string, array<string, string>>, translated: int}
     */
    public function completeGroups(array $groups): array
    {
        $translated = 0;

        foreach ($groups as $name => $values) {
            $normalized = [];
            foreach (self::LANGUAGES as $language) {
                $normalized[$language] = trim((string) ($values[$language] ?? ''));
            }

            $sourceLanguage = null;
            foreach (self::LANGUAGES as $language) {
                if ($normalized[$language] !== '') {
                    $sourceLanguage = $language;
                    break;
                }
            }

            if ($sourceLanguage === null) {
                throw new \RuntimeException(sprintf('Renseignez au moins une langue pour « %s ».', $name));
            }

            foreach (self::LANGUAGES as $targetLanguage) {
                if ($normalized[$targetLanguage] !== '') {
                    continue;
                }

                $normalized[$targetLanguage] = $this->translate(
                    $normalized[$sourceLanguage],
                    $sourceLanguage,
                    $targetLanguage,
                );
                ++$translated;
            }

            $groups[$name] = $normalized;
        }

        return ['groups' => $groups, 'translated' => $translated];
    }

    public function translate(string $text, string $sourceLanguage, string $targetLanguage): string
    {
        $text = trim($text);
        if ($text === '' || $sourceLanguage === $targetLanguage) {
            return $text;
        }

        if (!in_array($sourceLanguage, self::LANGUAGES, true) || !in_array($targetLanguage, self::LANGUAGES, true)) {
            throw new \InvalidArgumentException('Langue de traduction non prise en charge.');
        }

        $cacheKey = 'translation.'.hash('sha256', $this->provider."\0".$sourceLanguage."\0".$targetLanguage."\0".$text);
        $item = $this->cache->getItem($cacheKey);
        if ($item->isHit() && is_string($item->get())) {
            return $item->get();
        }

        $translation = match (strtolower($this->provider)) {
            'libretranslate' => $this->translateWithLibreTranslate($text, $sourceLanguage, $targetLanguage),
            'google' => $this->translateWithGoogle($text, $sourceLanguage, $targetLanguage),
            default => throw new \RuntimeException('Fournisseur de traduction inconnu.'),
        };

        if ($translation === '') {
            throw new \RuntimeException('Le service de traduction a renvoyé un texte vide.');
        }

        $item->set($translation)->expiresAfter(60 * 60 * 24 * 365);
        $this->cache->save($item);

        return $translation;
    }

    private function translateWithGoogle(string $text, string $sourceLanguage, string $targetLanguage): string
    {
        $url = rtrim($this->endpoint, '?').'?' . http_build_query([
            'client' => 'gtx',
            'sl' => $sourceLanguage,
            'tl' => $targetLanguage,
            'dt' => 't',
        ]);
        $data = $this->postForm($url, ['q' => $text]);

        if (!isset($data[0]) || !is_array($data[0])) {
            throw new \RuntimeException('Réponse invalide du service de traduction.');
        }

        $translation = '';
        foreach ($data[0] as $part) {
            if (is_array($part) && isset($part[0]) && is_string($part[0])) {
                $translation .= $part[0];
            }
        }

        return trim($translation);
    }

    private function translateWithLibreTranslate(string $text, string $sourceLanguage, string $targetLanguage): string
    {
        $payload = [
            'q' => $text,
            'source' => $sourceLanguage,
            'target' => $targetLanguage,
            'format' => str_contains($text, '<') ? 'html' : 'text',
        ];
        if ($this->apiKey !== '') {
            $payload['api_key'] = $this->apiKey;
        }

        $data = $this->postJson($this->endpoint, $payload);
        $translation = $data['translatedText'] ?? null;

        if (!is_string($translation)) {
            throw new \RuntimeException('Réponse invalide du service LibreTranslate.');
        }

        return trim($translation);
    }

    /** @param array<string, string> $payload */
    private function postForm(string $url, array $payload): array
    {
        return $this->request($url, http_build_query($payload), 'application/x-www-form-urlencoded');
    }

    /** @param array<string, string> $payload */
    private function postJson(string $url, array $payload): array
    {
        $body = json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);

        return $this->request($url, $body, 'application/json');
    }

    private function request(string $url, string $body, string $contentType): array
    {
        if (!function_exists('curl_init')) {
            throw new \RuntimeException('L’extension PHP cURL est requise pour la traduction automatique.');
        }

        $curl = curl_init($url);
        curl_setopt_array($curl, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $body,
            CURLOPT_HTTPHEADER => ['Content-Type: '.$contentType, 'Accept: application/json'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 8,
            CURLOPT_TIMEOUT => 45,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_USERAGENT => 'Bazma-CMS/1.0',
            CURLOPT_CAINFO => CaBundle::getSystemCaRootBundlePath(),
        ]);

        $response = curl_exec($curl);
        $status = (int) curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
        $error = curl_error($curl);
        curl_close($curl);

        if (!is_string($response) || $response === '' || $status < 200 || $status >= 300) {
            throw new \RuntimeException(sprintf(
                'Traduction automatique indisponible%s. Réessayez ou remplissez les traductions manuellement.',
                $error !== '' ? ' ('.$error.')' : '',
            ));
        }

        try {
            $decoded = json_decode($response, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException) {
            throw new \RuntimeException('Réponse illisible du service de traduction.');
        }

        if (!is_array($decoded)) {
            throw new \RuntimeException('Réponse invalide du service de traduction.');
        }

        return $decoded;
    }
}
