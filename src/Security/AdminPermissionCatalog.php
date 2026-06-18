<?php

namespace App\Security;

final class AdminPermissionCatalog
{
    /**
     * @return array<string, array<string, string>>
     */
    public static function groupedChoices(): array
    {
        return [
            'Accès global' => [
                'Super administrateur' => 'ROLE_SUPER_ADMIN',
            ],
            'Sections du CMS' => [
                'Accueil' => 'ROLE_HOME_MANAGER',
                'Pages' => 'ROLE_PAGE_MANAGER',
                'Médiathèque' => 'ROLE_MEDIA_MANAGER',
                'Actualités' => 'ROLE_NEWS_MANAGER',
                'Associations' => 'ROLE_ORGANIZATION_MANAGER',
                'Réseaux sociaux' => 'ROLE_SOCIAL_MANAGER',
                'Référencement et paramètres' => 'ROLE_SETTINGS_MANAGER',
                'Modérateurs' => 'ROLE_USER_MANAGER',
            ],
            'Actions sensibles' => [
                'Importer des médias dans l’éditeur' => 'ROLE_EDITOR_MEDIA_UPLOAD',
                'Supprimer des pages' => 'ROLE_PAGE_DELETE',
                'Supprimer des images' => 'ROLE_MEDIA_DELETE',
                'Supprimer des actualités' => 'ROLE_NEWS_DELETE',
                'Supprimer des associations' => 'ROLE_ORGANIZATION_DELETE',
                'Supprimer des liens sociaux' => 'ROLE_SOCIAL_DELETE',
                'Supprimer des modérateurs' => 'ROLE_USER_DELETE',
            ],
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function labels(): array
    {
        $labels = [];
        foreach (self::groupedChoices() as $choices) {
            foreach ($choices as $label => $role) {
                $labels[$role] = $label;
            }
        }

        return $labels;
    }

    public static function label(string $role): string
    {
        return self::labels()[$role] ?? strtolower(str_replace(['ROLE_', '_'], ['', ' '], $role));
    }
}
