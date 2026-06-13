<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260612183000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Seed polished front news examples';
    }

    public function up(Schema $schema): void
    {
        $this->addSql($this->isPostgreSql()
            ? "UPDATE event SET featured = false, position = position + 20 WHERE slug NOT IN ('actualite-photos-bazma', 'actualite-maison-jeunes-bazma', 'actualite-sport-bazma', 'actualite-associations-bazma')"
            : "UPDATE event SET featured = 0, position = position + 20 WHERE slug NOT IN ('actualite-photos-bazma', 'actualite-maison-jeunes-bazma', 'actualite-sport-bazma', 'actualite-associations-bazma')"
        );

        $items = [
            [
                'slug' => 'actualite-photos-bazma',
                'title' => 'Collecte officielle des photos de Bazma',
                'title_en' => 'Official Bazma photo collection',
                'title_ar' => 'جمع رسمي لصور بازمة',
                'category' => 'Mémoire',
                'event_date' => '2026-06-12',
                'location' => 'Bazma',
                'image_url' => '/assets/bazma-memory.webp',
                'excerpt' => 'Un appel à contribution pour réunir des photos autorisées du village, avec crédit, date, lieu et lien source.',
                'excerpt_en' => 'A contribution call to gather authorized village photos with credit, date, place and source link.',
                'excerpt_ar' => 'دعوة لجمع صور مرخصة للقرية مع الاعتماد والتاريخ والمكان ورابط المصدر.',
                'description' => "Le site Bazma ouvre une collecte éditoriale dédiée aux images du village. L'objectif est de publier uniquement des photos autorisées, correctement créditées et utiles à la mémoire locale.\n\nChaque contribution pourra être ajoutée depuis le CMS avec son titre, sa légende, son auteur, son lien source et son contexte.",
                'description_en' => "The Bazma website is opening an editorial collection dedicated to village images. The goal is to publish only authorized photos, properly credited and useful to local memory.\n\nEach contribution can be added through the CMS with its title, caption, author, source link and context.",
                'description_ar' => "يفتح موقع بازمة جمعا تحريريا مخصصا لصور القرية. الهدف هو نشر صور مرخصة فقط، مع ذكر صاحب الصورة والسياق والمصدر.\n\nيمكن إضافة كل مساهمة من نظام الإدارة مع العنوان والتعليق والرابط والمعلومات المحلية.",
                'position' => 1,
            ],
            [
                'slug' => 'actualite-maison-jeunes-bazma',
                'title' => 'La Maison des jeunes au coeur de l’archive locale',
                'title_en' => 'The youth center at the heart of the local archive',
                'title_ar' => 'دار الشباب في قلب الأرشيف المحلي',
                'category' => 'Jeunesse',
                'event_date' => '2026-06-10',
                'location' => 'Maison des jeunes de Bazma',
                'image_url' => '/assets/bazma-youth.webp',
                'excerpt' => 'Activités, annonces, formations et événements jeunesse peuvent maintenant être structurés comme de vraies actualités.',
                'excerpt_en' => 'Activities, announcements, trainings and youth events can now be structured as real news stories.',
                'excerpt_ar' => 'يمكن الآن تنظيم الأنشطة والإعلانات والتكوينات وتظاهرات الشباب كأخبار حقيقية.',
                'description' => "Le CMS permet de transformer les activités locales en actualités lisibles: image de couverture, résumé court, contenu complet, date, catégorie et lien source.\n\nCette structure aide à suivre les projets jeunesse et à garder une trace claire des moments importants pour Bazma.",
                'description_en' => "The CMS turns local activities into readable news: cover image, short summary, full story, date, category and source link.\n\nThis structure helps follow youth projects and keep a clear record of important moments for Bazma.",
                'description_ar' => "يسمح نظام الإدارة بتحويل الأنشطة المحلية إلى أخبار واضحة: صورة رئيسية، ملخص قصير، نص كامل، تاريخ، صنف ورابط مصدر.\n\nيساعد ذلك على متابعة مشاريع الشباب وحفظ لحظات مهمة لبازمة.",
                'position' => 2,
            ],
            [
                'slug' => 'actualite-sport-bazma',
                'title' => 'Sport à Bazma: matchs, équipes et mémoire collective',
                'title_en' => 'Sport in Bazma: matches, teams and shared memory',
                'title_ar' => 'الرياضة في بازمة: مباريات وفرق وذاكرة مشتركة',
                'category' => 'Sport',
                'event_date' => '2026-06-08',
                'location' => 'Bazma',
                'image_url' => '/assets/bazma-sport.webp',
                'excerpt' => 'Une rubrique pour documenter les équipes, les résultats, les photos de matchs et les parcours des jeunes sportifs.',
                'excerpt_en' => 'A section to document teams, results, match photos and youth sports journeys.',
                'excerpt_ar' => 'قسم لتوثيق الفرق والنتائج وصور المباريات ومسارات الشباب الرياضي.',
                'description' => "Les actualités sportives peuvent devenir une archive vivante: chaque match, tournoi, académie ou réussite locale peut être publié avec une image, une source et une date.\n\nLe but est de construire une mémoire sportive locale propre, consultable et facile à enrichir.",
                'description_en' => "Sports news can become a living archive: every match, tournament, academy moment or local success can be published with an image, source and date.\n\nThe goal is to build a clean local sports memory that is easy to browse and enrich.",
                'description_ar' => "يمكن أن تصبح الأخبار الرياضية أرشيفا حيا: كل مقابلة أو دورة أو نجاح محلي يمكن نشره بصورة ومصدر وتاريخ.\n\nالهدف هو بناء ذاكرة رياضية محلية واضحة وسهلة الإثراء.",
                'position' => 3,
            ],
            [
                'slug' => 'actualite-associations-bazma',
                'title' => 'Un annuaire vivant pour les associations de Bazma',
                'title_en' => 'A living directory for Bazma associations',
                'title_ar' => 'دليل حي لجمعيات بازمة',
                'category' => 'Associations',
                'event_date' => '2026-06-06',
                'location' => 'Bazma',
                'image_url' => '/assets/bazma-airport.webp',
                'excerpt' => 'Le site peut présenter les structures locales avec description, photo, lien source et statut de visibilité.',
                'excerpt_en' => 'The site can present local structures with description, photo, source link and visibility status.',
                'excerpt_ar' => 'يمكن للموقع عرض الهياكل المحلية مع الوصف والصورة ورابط المصدر وحالة الظهور.',
                'description' => "Les associations et structures locales disposent maintenant d’un espace clair dans le CMS. Une fiche peut contenir un type, une description multilingue, une image et un lien source.\n\nLes actualités permettent ensuite de raconter les actions importantes menées autour de Bazma.",
                'description_en' => "Local associations and structures now have a clear space in the CMS. A profile can include a type, multilingual description, image and source link.\n\nNews stories can then highlight important actions around Bazma.",
                'description_ar' => "أصبحت للجمعيات والهياكل المحلية مساحة واضحة في نظام الإدارة. يمكن أن تحتوي البطاقة على النوع والوصف متعدد اللغات والصورة ورابط المصدر.\n\nثم تسمح الأخبار بعرض الأعمال المهمة حول بازمة.",
                'position' => 4,
            ],
        ];

        foreach ($items as $item) {
            $this->addSql(
                $this->eventUpsertSql(),
                $item
            );
        }
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DELETE FROM event WHERE slug IN ('actualite-photos-bazma', 'actualite-maison-jeunes-bazma', 'actualite-sport-bazma', 'actualite-associations-bazma')");
    }

    private function eventUpsertSql(): string
    {
        if ($this->isPostgreSql()) {
            return "INSERT INTO event (title, slug, title_en, title_ar, event_date, location, category, source_url, image_url, excerpt, excerpt_en, excerpt_ar, featured, position, description, description_en, description_ar, published)
                 VALUES (:title, :slug, :title_en, :title_ar, :event_date, :location, :category, NULL, :image_url, :excerpt, :excerpt_en, :excerpt_ar, true, :position, :description, :description_en, :description_ar, true)
                 ON CONFLICT (slug) DO UPDATE SET title = EXCLUDED.title, title_en = EXCLUDED.title_en, title_ar = EXCLUDED.title_ar, event_date = EXCLUDED.event_date, location = EXCLUDED.location, category = EXCLUDED.category, image_url = EXCLUDED.image_url, excerpt = EXCLUDED.excerpt, excerpt_en = EXCLUDED.excerpt_en, excerpt_ar = EXCLUDED.excerpt_ar, featured = true, position = EXCLUDED.position, description = EXCLUDED.description, description_en = EXCLUDED.description_en, description_ar = EXCLUDED.description_ar, published = true";
        }

        return "INSERT INTO event (title, slug, title_en, title_ar, event_date, location, category, source_url, image_url, excerpt, excerpt_en, excerpt_ar, featured, position, description, description_en, description_ar, published)
                 VALUES (:title, :slug, :title_en, :title_ar, :event_date, :location, :category, NULL, :image_url, :excerpt, :excerpt_en, :excerpt_ar, 1, :position, :description, :description_en, :description_ar, 1)
                 ON DUPLICATE KEY UPDATE title = VALUES(title), title_en = VALUES(title_en), title_ar = VALUES(title_ar), event_date = VALUES(event_date), location = VALUES(location), category = VALUES(category), image_url = VALUES(image_url), excerpt = VALUES(excerpt), excerpt_en = VALUES(excerpt_en), excerpt_ar = VALUES(excerpt_ar), featured = 1, position = VALUES(position), description = VALUES(description), description_en = VALUES(description_en), description_ar = VALUES(description_ar), published = 1";
    }

    private function isPostgreSql(): bool
    {
        return str_contains($this->connection->getDatabasePlatform()::class, 'PostgreSQL');
    }
}
