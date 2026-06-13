<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260612170000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add editable homepage hero and facts settings';
    }

    public function up(Schema $schema): void
    {
        $settings = [
            'hero_image' => '/assets/bazma-hero.webp',
            'hero_eyebrow_fr' => 'Village de Kebili',
            'hero_eyebrow_en' => 'Kebili village',
            'hero_eyebrow_ar' => 'قرية من قبلي',
            'hero_title_fr' => 'Bazma, mémoire vivante du village',
            'hero_title_en' => 'Bazma, a living village memory',
            'hero_title_ar' => 'بازمة، ذاكرة قرية حيّة',
            'hero_intro_fr' => 'Une vitrine dédiée à Bazma: oasis, familles, jeunesse, photos publiques, sport, fêtes et projets locaux.',
            'hero_intro_en' => 'A showcase dedicated to Bazma: oasis, families, youth, public photos, sport, celebrations and local projects.',
            'hero_intro_ar' => 'واجهة مخصصة لبازمة: الواحة، العائلات، الشباب، الصور، الرياضة، المناسبات والمشاريع المحلية.',
            'hero_primary_label_fr' => 'Découvrir',
            'hero_primary_label_en' => 'Explore',
            'hero_primary_label_ar' => 'اكتشف',
            'hero_primary_url' => '#decouvrir',
            'hero_secondary_label_fr' => 'Voir les images',
            'hero_secondary_label_en' => 'View images',
            'hero_secondary_label_ar' => 'شاهد الصور',
            'hero_secondary_url' => '/fr/gallery',
            'home_fact_1_value' => '33.66583, 9.01167',
            'home_fact_1_label_fr' => 'Coordonnées',
            'home_fact_1_label_en' => 'Coordinates',
            'home_fact_1_label_ar' => 'الإحداثيات',
            'home_fact_2_value' => '6-9 km',
            'home_fact_2_label_fr' => 'De Kebili',
            'home_fact_2_label_en' => 'From Kebili',
            'home_fact_2_label_ar' => 'من قبلي',
            'home_fact_3_value' => 'Oasis',
            'home_fact_3_label_fr' => 'Paysage local',
            'home_fact_3_label_en' => 'Local landscape',
            'home_fact_3_label_ar' => 'المشهد المحلي',
            'home_fact_4_value' => 'BWh',
            'home_fact_4_label_fr' => 'Climat aride',
            'home_fact_4_label_en' => 'Arid climate',
            'home_fact_4_label_ar' => 'مناخ جاف',
        ];

        foreach ($settings as $key => $value) {
            $this->addSql(
                'INSERT INTO site_setting (setting_key, setting_value) VALUES (:setting_key, :setting_value) ON DUPLICATE KEY UPDATE setting_key = setting_key',
                ['setting_key' => $key, 'setting_value' => $value]
            );
        }
    }

    public function down(Schema $schema): void
    {
        $keys = [
            'hero_eyebrow_fr',
            'hero_eyebrow_en',
            'hero_eyebrow_ar',
            'hero_title_fr',
            'hero_title_en',
            'hero_title_ar',
            'hero_intro_fr',
            'hero_intro_en',
            'hero_intro_ar',
            'hero_primary_label_fr',
            'hero_primary_label_en',
            'hero_primary_label_ar',
            'hero_primary_url',
            'hero_secondary_label_fr',
            'hero_secondary_label_en',
            'hero_secondary_label_ar',
            'hero_secondary_url',
            'home_fact_1_value',
            'home_fact_1_label_fr',
            'home_fact_1_label_en',
            'home_fact_1_label_ar',
            'home_fact_2_value',
            'home_fact_2_label_fr',
            'home_fact_2_label_en',
            'home_fact_2_label_ar',
            'home_fact_3_value',
            'home_fact_3_label_fr',
            'home_fact_3_label_en',
            'home_fact_3_label_ar',
            'home_fact_4_value',
            'home_fact_4_label_fr',
            'home_fact_4_label_en',
            'home_fact_4_label_ar',
        ];

        $this->addSql('DELETE FROM site_setting WHERE setting_key IN (:keys)', ['keys' => $keys], ['keys' => \Doctrine\DBAL\Connection::PARAM_STR_ARRAY]);
    }
}
