<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260612171000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add editable homepage labels and section copy settings';
    }

    public function up(Schema $schema): void
    {
        $settings = [
            'brand_fr' => 'Bazma Kebili',
            'brand_en' => 'Bazma Kebili',
            'brand_ar' => 'بازمة قبلي',
            'nav_home_fr' => 'Accueil',
            'nav_home_en' => 'Home',
            'nav_home_ar' => 'الرئيسية',
            'nav_discover_fr' => 'Découvrir',
            'nav_discover_en' => 'Discover',
            'nav_discover_ar' => 'اكتشف',
            'nav_gallery_fr' => 'Galerie',
            'nav_gallery_en' => 'Gallery',
            'nav_gallery_ar' => 'الصور',
            'nav_associations_fr' => 'Associations',
            'nav_associations_en' => 'Associations',
            'nav_associations_ar' => 'الجمعيات',
            'nav_social_fr' => 'Réseaux',
            'nav_social_en' => 'Social',
            'nav_social_ar' => 'الشبكات',
            'nav_news_fr' => 'Actualités',
            'nav_news_en' => 'News',
            'nav_news_ar' => 'الأخبار',
            'home_discover_eyebrow_fr' => 'Découvrir Bazma',
            'home_discover_eyebrow_en' => 'Discover Bazma',
            'home_discover_eyebrow_ar' => 'اكتشف بازمة',
            'home_discover_title_fr' => 'Un territoire à documenter avec ses habitants',
            'home_discover_title_en' => 'A place to document with its residents',
            'home_discover_title_ar' => 'قرية نوثقها مع أهلها',
            'home_images_eyebrow_fr' => 'Images',
            'home_images_eyebrow_en' => 'Images',
            'home_images_eyebrow_ar' => 'الصور',
            'home_images_title_fr' => 'Palmeraies, lumière du désert et vie locale',
            'home_images_title_en' => 'Palm groves, desert light and local life',
            'home_images_title_ar' => 'النخيل، ضوء الصحراء والحياة المحلية',
            'home_associations_eyebrow_fr' => 'Associations locales',
            'home_associations_eyebrow_en' => 'Local associations',
            'home_associations_eyebrow_ar' => 'الجمعيات المحلية',
            'home_associations_title_fr' => 'Associations et structures actives autour de Bazma',
            'home_associations_title_en' => 'Associations and active local structures around Bazma',
            'home_associations_title_ar' => 'جمعيات وهياكل نشطة حول بازمة',
            'home_associations_text_fr' => 'Cette liste peut être complétée depuis le CMS dès qu’une source fiable est disponible.',
            'home_associations_text_en' => 'This list can be completed from the CMS whenever a reliable source is available.',
            'home_associations_text_ar' => 'يمكن إكمال هذه القائمة من نظام الإدارة كلما توفر مصدر موثوق.',
            'home_social_eyebrow_fr' => 'Bazma sur les réseaux',
            'home_social_eyebrow_en' => 'Bazma on social media',
            'home_social_eyebrow_ar' => 'بازمة على الشبكات',
            'home_social_title_fr' => 'Les traces publiques de Bazma',
            'home_social_title_en' => 'Public traces of Bazma',
            'home_social_title_ar' => 'آثار بازمة المنشورة',
            'home_social_text_fr' => 'Liens vers les pages et publications publiques liées à Bazma, à valider avant reprise de photos.',
            'home_social_text_en' => 'Links to public pages and posts related to Bazma, to validate before reusing photos.',
            'home_social_text_ar' => 'روابط لصفحات ومنشورات عامة حول بازمة، مع التثبت قبل استعمال الصور.',
            'home_news_eyebrow_fr' => 'CMS local',
            'home_news_eyebrow_en' => 'Local CMS',
            'home_news_eyebrow_ar' => 'نظام محلي',
            'home_news_title_fr' => 'Une vitrine qui peut évoluer',
            'home_news_title_en' => 'A showcase that can evolve',
            'home_news_title_ar' => 'واجهة قابلة للتطور',
            'home_news_text_fr' => 'Pages, images, crédits, événements et textes importants sont administrables depuis un espace sécurisé.',
            'home_news_text_en' => 'Pages, images, credits, events and important texts are managed from a secure space.',
            'home_news_text_ar' => 'الصفحات والصور والاعتمادات والأحداث والنصوص المهمة تدار من فضاء آمن.',
            'read_more_fr' => 'Lire',
            'read_more_en' => 'Read',
            'read_more_ar' => 'اقرأ',
            'source_label_fr' => 'Source',
            'source_label_en' => 'Source',
            'source_label_ar' => 'المصدر',
            'news_source_label_fr' => 'Lire la source',
            'news_source_label_en' => 'Read source',
            'news_source_label_ar' => 'قراءة المصدر',
            'planned_label_fr' => 'À planifier',
            'planned_label_en' => 'Planned',
            'planned_label_ar' => 'قيد البرمجة',
            'no_news_fr' => 'Aucune actualité publiée',
            'no_news_en' => 'No published news',
            'no_news_ar' => 'لا توجد أخبار منشورة',
        ];

        foreach ($settings as $key => $value) {
            $this->addSql(
                $this->settingInsertSql(),
                ['setting_key' => $key, 'setting_value' => $value]
            );
        }
    }

    public function down(Schema $schema): void
    {
        if ($this->isPostgreSql()) {
            $this->addSql("DELETE FROM site_setting WHERE setting_key ~ '^(brand|nav_|home_|read_more_|source_label_|news_source_label_|planned_label_|no_news_)'");

            return;
        }

        $this->addSql("DELETE FROM site_setting WHERE setting_key REGEXP '^(brand|nav_|home_|read_more_|source_label_|news_source_label_|planned_label_|no_news_)'");
    }

    private function settingInsertSql(): string
    {
        if ($this->isPostgreSql()) {
            return 'INSERT INTO site_setting (setting_key, setting_value) VALUES (:setting_key, :setting_value) ON CONFLICT (setting_key) DO NOTHING';
        }

        return 'INSERT INTO site_setting (setting_key, setting_value) VALUES (:setting_key, :setting_value) ON DUPLICATE KEY UPDATE setting_key = setting_key';
    }

    private function isPostgreSql(): bool
    {
        return str_contains($this->connection->getDatabasePlatform()::class, 'PostgreSQL');
    }
}
