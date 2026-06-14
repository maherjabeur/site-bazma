<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260614100000 extends AbstractMigration
{
    private const NEWS_COPY = [
        'home_news_eyebrow_fr' => 'Actualités locales',
        'home_news_eyebrow_en' => 'Local news',
        'home_news_eyebrow_ar' => 'أخبار محلية',
        'home_news_title_fr' => 'Actualités, événements et initiatives de Bazma',
        'home_news_title_en' => 'Bazma news, events and initiatives',
        'home_news_title_ar' => 'أخبار بازمة وفعالياتها ومبادراتها',
        'home_news_text_fr' => 'Suivez les nouvelles publiées autour de Bazma: annonces locales, activités de jeunesse, actions associatives, sport, photos autorisées et événements importants du village.',
        'home_news_text_en' => 'Follow updates from Bazma: local announcements, youth activities, association work, sports, authorized photos and important village events.',
        'home_news_text_ar' => 'تابع مستجدات بازمة: الإعلانات المحلية، أنشطة الشباب، أعمال الجمعيات، الرياضة، الصور المرخصة والأحداث المهمة في القرية.',
    ];

    private const PREVIOUS_COPY = [
        'home_news_eyebrow_fr' => 'CMS local',
        'home_news_eyebrow_en' => 'Local CMS',
        'home_news_eyebrow_ar' => 'نظام محلي',
        'home_news_title_fr' => 'Une vitrine qui peut évoluer',
        'home_news_title_en' => 'A showcase that can evolve',
        'home_news_title_ar' => 'واجهة قابلة للتطور',
        'home_news_text_fr' => 'Pages, images, crédits, événements et textes importants sont administrables depuis un espace sécurisé.',
        'home_news_text_en' => 'Pages, images, credits, events and important texts are managed from a secure space.',
        'home_news_text_ar' => 'الصفحات والصور والاعتمادات والأحداث والنصوص المهمة تدار من فضاء آمن.',
    ];

    public function getDescription(): string
    {
        return 'Update homepage news section copy in French, English and Arabic';
    }

    public function up(Schema $schema): void
    {
        $this->upsertSettings(self::NEWS_COPY);
    }

    public function down(Schema $schema): void
    {
        $this->upsertSettings(self::PREVIOUS_COPY);
    }

    /**
     * @param array<string, string> $settings
     */
    private function upsertSettings(array $settings): void
    {
        foreach ($settings as $key => $value) {
            $this->addSql($this->settingUpsertSql(), [
                'setting_key' => $key,
                'setting_value' => $value,
            ]);
        }
    }

    private function settingUpsertSql(): string
    {
        if ($this->isPostgreSql()) {
            return 'INSERT INTO site_setting (setting_key, setting_value) VALUES (:setting_key, :setting_value) ON CONFLICT (setting_key) DO UPDATE SET setting_value = EXCLUDED.setting_value';
        }

        return 'INSERT INTO site_setting (setting_key, setting_value) VALUES (:setting_key, :setting_value) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)';
    }

    private function isPostgreSql(): bool
    {
        return str_contains($this->connection->getDatabasePlatform()::class, 'PostgreSQL');
    }
}
