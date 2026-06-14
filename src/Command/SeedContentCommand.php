<?php

namespace App\Command;

use App\Entity\Event;
use App\Entity\CommunityOrganization;
use App\Entity\GalleryImage;
use App\Entity\Page;
use App\Entity\SiteSetting;
use App\Entity\SocialLink;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:seed-content', description: 'Charge le contenu initial du site Bazma.')]
class SeedContentCommand extends Command
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        foreach ([Page::class, GalleryImage::class, Event::class, SiteSetting::class, SocialLink::class, CommunityOrganization::class] as $class) {
            foreach ($this->em->getRepository($class)->findAll() as $entity) {
                $this->em->remove($entity);
            }
        }
        $this->em->flush();

        $settings = [
            'site_title' => 'Bazma, mémoire vivante du village',
            'site_title_en' => 'Bazma, a living village memory',
            'site_title_ar' => 'بازمة، ذاكرة قرية حيّة',
            'site_intro' => 'Une vitrine dédiée uniquement à Bazma: oasis, familles, jeunesse, photos publiques, sports, fêtes et projets locaux.',
            'site_intro_en' => 'A showcase dedicated only to Bazma: oasis, families, youth, public photos, sports, celebrations and local projects.',
            'site_intro_ar' => 'واجهة مخصصة لبازمة فقط: الواحة، العائلات، الشباب، الصور المنشورة، الرياضة، المناسبات والمشاريع المحلية.',
            'seo_title_ar' => 'بازمة قبلي | ذاكرة القرية والصور والشبكات المحلية',
            'seo_title_fr' => 'Bazma Kebili | Mémoire, photos et réseaux du village',
            'seo_title_en' => 'Bazma Kebili | Village memory, photos and local networks',
            'seo_description_ar' => 'موقع بازمة قبلي لجمع ذاكرة القرية: الواحة، الأهالي، الصور المرخصة، دار الشباب، الرياضة، التقاليد وروابط فيسبوك المحلية.',
            'seo_description_fr' => 'Site Bazma Kebili pour collecter la mémoire du village: oasis, habitants, photos autorisées, Maison des jeunes, sport, traditions et liens Facebook locaux.',
            'seo_description_en' => 'Bazma Kebili website collecting village memory: oasis, people, authorized photos, youth center, sport, traditions and local Facebook links.',
            'og_image' => '/assets/bazma-hero.webp',
            'footer_text_ar' => 'ذاكرة حيّة لبازمة تُبنى مع الأهالي والمصادر المحلية المرخّصة.',
            'footer_text_fr' => 'Mémoire vivante de Bazma, construite avec les habitants et les sources locales autorisées.',
            'footer_text_en' => 'A living memory of Bazma, built with residents and authorized local sources.',
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
            'home_news_eyebrow_fr' => 'Actualités locales',
            'home_news_eyebrow_en' => 'Local news',
            'home_news_eyebrow_ar' => 'أخبار محلية',
            'home_news_title_fr' => 'Actualités, événements et initiatives de Bazma',
            'home_news_title_en' => 'Bazma news, events and initiatives',
            'home_news_title_ar' => 'أخبار بازمة وفعالياتها ومبادراتها',
            'home_news_text_fr' => 'Suivez les nouvelles publiées autour de Bazma: annonces locales, activités de jeunesse, actions associatives, sport, photos autorisées et événements importants du village.',
            'home_news_text_en' => 'Follow updates from Bazma: local announcements, youth activities, association work, sports, authorized photos and important village events.',
            'home_news_text_ar' => 'تابع مستجدات بازمة: الإعلانات المحلية، أنشطة الشباب، أعمال الجمعيات، الرياضة، الصور المرخصة والأحداث المهمة في القرية.',
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
            $this->em->persist((new SiteSetting())->setSettingKey($key)->setSettingValue($value));
        }

        $pages = [
            [
                'title' => 'Bazma en bref',
                'titleEn' => 'Bazma at a glance',
                'titleAr' => 'بازمة في لمحة',
                'slug' => 'bazma-en-bref',
                'summary' => 'Bazma est un village oasien de la délégation de Kébili Sud, avec une identité locale forte.',
                'summaryEn' => 'Bazma is an oasis village in the Kebili South delegation, with a strong local identity.',
                'summaryAr' => 'بازمة قرية واحية من معتمدية قبلي الجنوبية، ولها هوية محلية واضحة.',
                'body' => "Bazma est située près de Kébili, dans le Sud tunisien. Les sources géographiques publiques la placent autour de 33.66583 N et 9.01167 E. Ce site doit rester centré sur Bazma seulement: ses habitants, ses lieux, son oasis, sa jeunesse, ses photos et ses archives.\n\nLe contenu initial combine des sources publiques classiques et des traces sociales visibles sur Facebook. Les photos exactes de Bazma repérées sur les réseaux ne sont pas copiées sans autorisation: elles sont référencées pour contacter les auteurs, demander l'accord, puis ajouter les images avec crédit dans le CMS.",
                'bodyEn' => "Bazma is located near Kebili in southern Tunisia. Public geographic sources place it around 33.66583 N and 9.01167 E. This website must stay focused only on Bazma: its people, places, oasis, youth, photos and archives.\n\nThe starter content combines public reference sources and social traces visible on Facebook. Exact Bazma photos found on social media are not copied without permission: they are referenced so authors can be contacted, permission requested and credited photos added through the CMS.",
                'bodyAr' => "تقع بازمة قرب قبلي في الجنوب التونسي. وتضعها المصادر الجغرافية العامة حول الإحداثيات 33.66583 شمالا و9.01167 شرقا. يجب أن يبقى هذا الموقع مخصصا لبازمة فقط: أهلها، أماكنها، واحتها، شبابها، صورها وأرشيفها.\n\nيمزج المحتوى الأولي بين مصادر عامة وآثار اجتماعية منشورة على فيسبوك. لا يتم نسخ صور بازمة الدقيقة من الشبكات دون إذن، بل توضع الروابط للتواصل مع أصحابها وطلب الموافقة ثم إضافة الصور مع الاعتماد داخل نظام الإدارة.",
                'image' => '/assets/bazma-oasis.webp',
            ],
            [
                'title' => 'Oasis, eau et terre',
                'titleEn' => 'Oasis, water and land',
                'titleAr' => 'الواحة والماء والأرض',
                'slug' => 'oasis-eau-terre',
                'summary' => 'La mémoire de Bazma passe par son oasis, l’eau, les cultures et le travail de la terre.',
                'summaryEn' => 'Bazma’s memory runs through its oasis, water, crops and work on the land.',
                'summaryAr' => 'تمر ذاكرة بازمة عبر الواحة والماء والزراعات وخدمة الأرض.',
                'body' => "Le document FIES du ministère tunisien de l'environnement mentionne l'oasis de Bazma dans le cadre d'un projet de réhabilitation du périmètre irrigué. La page arabe de Bazma signale aussi la réputation du village autour de la terre et des cultures maraîchères.\n\nCette page doit devenir un espace local: noms des parcelles, puits, souvenirs de récoltes, techniques d'irrigation, anciennes photos d'oasis et témoignages d'agriculteurs.",
                'bodyEn' => "The FIES document from the Tunisian Ministry of Environment mentions the Bazma oasis as part of an irrigated perimeter rehabilitation project. The Arabic page about Bazma also points to the village’s reputation for working the land and growing vegetables.\n\nThis page should become a local space: plot names, wells, harvest memories, irrigation practices, old oasis photos and farmers’ testimonies.",
                'bodyAr' => "تذكر وثيقة FIES لوزارة البيئة التونسية واحة بازمة ضمن مشروع إعادة تأهيل محيط سقوي. كما تشير الصفحة العربية الخاصة ببازمة إلى شهرة القرية بخدمة الأرض وغراسة الخضر.\n\nيمكن أن تصبح هذه الصفحة فضاء محليا لأسماء القطع والآبار وذكريات الجني وتقنيات الري والصور القديمة للواحة وشهادات الفلاحين.",
                'image' => '/assets/bazma-oasis.webp',
            ],
            [
                'title' => 'Jeunesse et Maison des jeunes',
                'titleEn' => 'Youth and youth center',
                'titleAr' => 'الشباب ودار الشباب',
                'slug' => 'jeunesse-maison-des-jeunes',
                'summary' => 'Les publications de دار الشباب بازمة montrent une activité locale importante autour des jeunes.',
                'summaryEn' => 'Posts from دار الشباب بازمة show important local activity around young people.',
                'summaryAr' => 'تظهر منشورات دار الشباب بازمة نشاطا محليا مهما موجها للشباب.',
                'body' => "La page Facebook دار الشباب بازمة publie des annonces, activités, rencontres et contenus liés aux jeunes de Bazma. Des sources comme Jeun'ESS / EU4Youth mentionnent aussi des initiatives à la Maison des jeunes de Bazma.\n\nLe site doit référencer ces actions: orientation des élèves, activités culturelles, projets citoyens, formations, événements et photos validées par les responsables.",
                'bodyEn' => "The دار الشباب بازمة Facebook page publishes announcements, activities, meetings and content linked to Bazma’s youth. Sources such as Jeun'ESS / EU4Youth also mention initiatives at the Bazma youth center.\n\nThe website should reference these actions: student guidance, cultural activities, civic projects, trainings, events and photos approved by the people in charge.",
                'bodyAr' => "تنشر صفحة دار الشباب بازمة على فيسبوك إعلانات وأنشطة ولقاءات ومحتويات مرتبطة بشباب بازمة. كما تذكر مصادر مثل Jeun'ESS / EU4Youth مبادرات في دار الشباب بازمة.\n\nينبغي أن يوثق الموقع هذه الأنشطة: توجيه التلاميذ، الأنشطة الثقافية، المشاريع المواطنة، التكوينات، التظاهرات والصور المصادق عليها من المسؤولين.",
                'image' => '/assets/bazma-youth.webp',
            ],
            [
                'title' => 'Fêtes, chevaux et vie sociale',
                'titleEn' => 'Celebrations, horses and social life',
                'titleAr' => 'المناسبات والخيول والحياة الاجتماعية',
                'slug' => 'fetes-chevaux-vie-sociale',
                'summary' => 'Des publications Facebook récentes documentent des moments de fête et de vie sociale à Bazma.',
                'summaryEn' => 'Recent Facebook posts document celebrations and social life moments in Bazma.',
                'summaryAr' => 'توثق منشورات فيسبوك حديثة مناسبات ولحظات اجتماعية في بازمة.',
                'body' => "Camera Andalib a publié des contenus autour de عشوية الخيل / ثاني العيد à قرية بازمة، قبلي. Ces contenus sont précieux pour raconter la vie sociale, les fêtes, les chevaux et les rassemblements.\n\nLes images ne sont pas intégrées directement sans accord. La bonne procédure: contacter le studio ou l'auteur, récupérer l'image autorisée, indiquer le crédit, puis l'ajouter dans la galerie du CMS.",
                'bodyEn' => "Camera Andalib published content around عشوية الخيل / ثاني العيد in قرية بازمة، قبلي. These posts are valuable for telling the story of social life, celebrations, horses and gatherings.\n\nImages are not embedded directly without permission. The right process is to contact the studio or author, obtain the authorized image, add the credit and then upload it to the CMS gallery.",
                'bodyAr' => "نشرت كاميرا العندليب محتوى حول عشوية الخيل / ثاني العيد في قرية بازمة، قبلي. هذه المنشورات مهمة لتوثيق الحياة الاجتماعية والمناسبات والخيول والتجمعات.\n\nلا تدرج الصور مباشرة دون إذن. الطريقة الصحيحة هي التواصل مع الاستوديو أو صاحب الصورة، الحصول على صورة مرخصة، ذكر الاعتماد ثم إضافتها إلى معرض نظام الإدارة.",
                'image' => '/assets/bazma-horses.webp',
            ],
            [
                'title' => 'Sport et équipes de Bazma',
                'titleEn' => 'Sport and Bazma teams',
                'titleAr' => 'الرياضة وفرق بازمة',
                'slug' => 'sport-equipes-bazma',
                'summary' => 'Facebook garde des traces de matchs, d’académies et de jeunes sportifs liés à Bazma.',
                'summaryEn' => 'Facebook keeps traces of matches, academies and young athletes linked to Bazma.',
                'summaryAr' => 'يحفظ فيسبوك آثار مباريات وأكاديميات وشباب رياضيين مرتبطين ببازمة.',
                'body' => "Des résultats de recherche montrent des publications sur des matchs impliquant Bazma, notamment une publication ancienne de la Commune de Kébili et des contenus récents autour d'une académie de Bazma.\n\nCette page peut devenir l'archive sportive du village: équipes, photos de matchs, noms des joueurs, résultats, tournois locaux, médailles et parcours des jeunes.",
                'bodyEn' => "Search results show posts about matches involving Bazma, including an older post from the Commune of Kebili and recent content around a Bazma academy.\n\nThis page can become the village sports archive: teams, match photos, player names, results, local tournaments, medals and youth journeys.",
                'bodyAr' => "تظهر نتائج البحث منشورات حول مباريات شاركت فيها بازمة، منها منشور قديم لبلدية قبلي ومحتويات حديثة حول أكاديمية بازمة.\n\nيمكن أن تصبح هذه الصفحة أرشيفا رياضيا للقرية: الفرق، صور المباريات، أسماء اللاعبين، النتائج، الدورات المحلية، الميداليات ومسارات الشباب.",
                'image' => '/assets/bazma-sport.webp',
            ],
            [
                'title' => 'Photos de Bazma: méthode de collecte',
                'titleEn' => 'Bazma photos: collection method',
                'titleAr' => 'صور بازمة: طريقة الجمع',
                'slug' => 'photos-bazma-collecte',
                'summary' => 'Les vraies images de Bazma doivent venir des habitants, pages locales et publications Facebook autorisées.',
                'summaryEn' => 'Real Bazma images should come from residents, local pages and authorized Facebook posts.',
                'summaryAr' => 'يجب أن تأتي صور بازمة الحقيقية من السكان والصفحات المحلية ومنشورات فيسبوك المرخصة.',
                'body' => "Sources prioritaires à contacter: Airport kebili-Bazma, دار الشباب بازمة, Bazma بازمة حكاية بلد bazma 2, Camera Andalib, pages sportives et publications publiques qui mentionnent قرية بازمة.\n\nAvant publication: demander l'accord, noter l'auteur, la date, le lieu, la légende, le lien source et le niveau d'autorisation. Ensuite, ajouter l'image au CMS avec son crédit. Cette règle protège le site et respecte les habitants.",
                'bodyEn' => "Priority sources to contact: Airport kebili-Bazma, دار الشباب بازمة, Bazma بازمة حكاية بلد bazma 2, Camera Andalib, sports pages and public posts mentioning قرية بازمة.\n\nBefore publication: ask permission, record author, date, place, caption, source link and permission level. Then add the image to the CMS with its credit. This rule protects the website and respects residents.",
                'bodyAr' => "مصادر ذات أولوية للتواصل: Airport kebili-Bazma، دار الشباب بازمة، Bazma بازمة حكاية بلد bazma 2، كاميرا العندليب، الصفحات الرياضية والمنشورات العامة التي تذكر قرية بازمة.\n\nقبل النشر: طلب الإذن، تسجيل اسم صاحب الصورة، التاريخ، المكان، التعليق، رابط المصدر ومستوى الترخيص. بعد ذلك تضاف الصورة إلى نظام الإدارة مع الاعتماد. هذه القاعدة تحمي الموقع وتحترم أهل القرية.",
                'image' => '/assets/bazma-memory.webp',
            ],
        ];

        foreach ($pages as $position => $page) {
            $this->em->persist((new Page())
                ->setTitle($page['title'])
                ->setTitleEn($page['titleEn'])
                ->setTitleAr($page['titleAr'])
                ->setSlug($page['slug'])
                ->setSummary($page['summary'])
                ->setSummaryEn($page['summaryEn'])
                ->setSummaryAr($page['summaryAr'])
                ->setBody($page['body'])
                ->setBodyEn($page['bodyEn'])
                ->setBodyAr($page['bodyAr'])
                ->setImageUrl($page['image'])
                ->setPosition($position + 1)
                ->setPublished(true));
        }

        $socialLinks = [
            ['Airport kebili-Bazma', 'Airport kebili-Bazma', 'Airport kebili-Bazma', 'Page publique avec photos, albums, vidéos et publications autour de Bazma.', 'Public page with photos, albums, videos and posts around Bazma.', 'صفحة عامة تضم صورا وألبومات وفيديوهات ومنشورات حول بازمة.', 'https://www.facebook.com/AirportBazma/', '/assets/bazma-airport.webp', 'Page'],
            ['Photos Airport kebili-Bazma', 'Airport kebili-Bazma photos', 'صور Airport kebili-Bazma', 'Albums publics à vérifier pour récupérer des images de Bazma avec accord.', 'Public albums to review for Bazma images with permission.', 'ألبومات عامة يمكن مراجعتها للحصول على صور بازمة بإذن.', 'https://www.facebook.com/AirportBazma/photos/', '/assets/bazma-airport.webp', 'Photos'],
            ['دار الشباب بازمة', 'Bazma youth center', 'دار الشباب بازمة', 'Page Facebook locale liée aux activités, annonces et événements de la jeunesse à Bazma.', 'Local Facebook page linked to youth activities, announcements and events in Bazma.', 'صفحة محلية مرتبطة بأنشطة وإعلانات وتظاهرات الشباب في بازمة.', 'https://www.facebook.com/p/%D8%AF%D8%A7%D8%B1-%D8%A7%D9%84%D8%B4%D8%A8%D8%A7%D8%A8-%D8%A8%D8%A7%D8%B2%D9%85%D8%A9-100089146635794/', '/assets/bazma-youth.webp', 'Jeunesse'],
            ['Bazma بازمة حكاية بلد', 'Bazma story page', 'بازمة حكاية بلد', 'Page sociale centrée sur des nouvelles, réussites et fragments de mémoire de Bazma.', 'Social page focused on news, achievements and memory fragments from Bazma.', 'صفحة اجتماعية حول أخبار ونجاحات وذاكرة بازمة.', 'https://www.facebook.com/p/Bazma-%D8%A8%D8%A7%D8%B2%D9%85%D8%A9-%D8%AD%D9%83%D8%A7%D9%8A%D8%A9-%D8%A8%D9%84%D8%AF-bazma-2-100071547231876/', '/assets/bazma-memory.webp', 'Mémoire'],
            ['Camera Andalib - عشوية الخيل', 'Camera Andalib - horse evening', 'كاميرا العندليب - عشوية الخيل', 'Publication récente avec photos de عشوية الخيل / ثاني العيد à قرية بازمة، قبلي.', 'Recent post with photos from the horse evening / Eid event in Bazma village.', 'منشور حديث بصور عشوية الخيل / ثاني العيد في قرية بازمة، قبلي.', 'https://www.facebook.com/andalibstudio/posts/%D8%A8%D8%B9%D8%B6-%D9%85%D9%86-%D8%A7%D9%84%D8%B5%D9%88%D8%B1-%D9%84%D9%85%D9%88%D8%A7%D9%83%D8%A8%D8%A9-%D9%83%D8%A7%D9%85%D9%8A%D8%B1%D8%A7-%D8%A7%D9%84%D8%B9%D9%86%D8%AF%D9%84%D9%8A%D8%A8-%D9%84%D8%B9%D8%B4%D9%88%D9%8A%D8%A9-%D8%A7%D9%84%D8%AE%D9%8A%D9%84-%D8%AB%D8%A7%D9%86%D9%8A-%D8%A7%D9%84%D8%B9%D9%8A%D8%AF-%D9%82%D8%B1%D9%8A%D8%A9-%D8%A8%D8%A7%D8%B2%D9%85%D8%A9%D9%82%D8%A8%D9%84%D9%8A/1543426467143094/', '/assets/bazma-horses.webp', 'Traditions'],
            ['Commune Kebili - match Bazma', 'Kebili commune - Bazma match', 'بلدية قبلي - مباراة بازمة', 'Publication publique sur une rencontre sportive impliquant Bazma.', 'Public post about a sports match involving Bazma.', 'منشور عام حول مقابلة رياضية شاركت فيها بازمة.', 'https://www.facebook.com/commune.kebili/posts/%D8%B5%D9%88%D8%B1-%D9%85%D9%86-%D9%85%D8%A8%D8%A7%D8%B1%D8%A7%D8%A9-%D8%A8%D8%A7%D8%B2%D9%85%D8%A9-%D9%88-%D8%A7%D9%84%D8%B1%D8%AD%D9%85%D8%A7%D8%AA-%D9%8A%D9%88%D9%85-%D8%A7%D9%85%D8%B3-%D8%A8%D8%A7%D9%84%D9%85%D9%84%D8%B9%D8%A8-%D8%A7%D9%84%D8%A8%D9%84%D8%AF%D9%8A-%D8%A7%D9%84%D9%87%D8%A7%D8%AF%D9%8A-%D8%A7%D9%84%D8%AF%D9%88%D9%81-%D8%A7%D9%84%D9%86%D8%B2%D9%84%D8%A9-%D9%82%D8%A8%D9%84%D9%8A-%D8%B6%D9%85/2912977192098679/', '/assets/bazma-sport.webp', 'Sport'],
            ['Jeun’ESS - Maison des jeunes de Bazma', 'Jeun’ESS - Bazma youth center', 'Jeun’ESS - دار الشباب بازمة', 'Vidéo/projet mentionnant la Maison des jeunes de Bazma, Kebili.', 'Video/project mentioning the Bazma youth center, Kebili.', 'فيديو/مشروع يذكر دار الشباب بازمة، قبلي.', 'https://www.facebook.com/jeuness.eu4youth/videos/limitless-generation-a%CC%80-la-maison-des-jeunes-de-bazma-kebili/1015270436479405/', '/assets/bazma-youth.webp', 'Projet'],
            ['Elite Football - Académie Bazma', 'Elite Football - Bazma academy', 'Elite Football - أكاديمية بازمة', 'Publication sportive récente mentionnant une académie de Bazma.', 'Recent sports post mentioning a Bazma academy.', 'منشور رياضي حديث يذكر أكاديمية بازمة.', 'https://www.facebook.com/Elite.football.academie.kebili/posts/%D9%81%D8%B1%D8%B9-%D8%A7%D9%84%D8%A8%D8%B1%D8%BA%D9%88%D8%AB%D9%8A%D8%A9-%D8%A8%D8%B9%D8%B6-%D8%B5%D9%88%D8%B1-%D8%A7%D9%84%D9%85%D8%A8%D8%A7%D8%B1%D9%8A%D8%A7%D8%AA-%D9%85%D8%B9-%D8%A7%D9%83%D8%A7%D8%AF%D9%8A%D9%85%D9%8A%D8%A9-%D8%A8%D8%A7%D8%B2%D9%85%D8%A9-elite%D8%AA%D8%B9%D9%8A%D8%B4/993128719884600/', '/assets/bazma-sport.webp', 'Sport'],
        ];

        foreach ($socialLinks as $position => [$title, $titleEn, $titleAr, $summary, $summaryEn, $summaryAr, $url, $image, $category]) {
            $this->em->persist((new SocialLink())
                ->setPlatform('Facebook')
                ->setTitle($title)
                ->setTitleEn($titleEn)
                ->setTitleAr($titleAr)
                ->setSummary($summary)
                ->setSummaryEn($summaryEn)
                ->setSummaryAr($summaryAr)
                ->setUrl($url)
                ->setImageUrl($image)
                ->setCategory($category)
                ->setFeatured(true)
                ->setPosition($position + 1));
        }

        $organizations = [
            [
                'name' => 'Association Bazma culture, tourisme et loisirs',
                'nameEn' => 'Bazma Association for Culture, Tourism and Leisure',
                'nameAr' => 'جمعية بازمة للثقافة والسياحة والترفيه',
                'type' => 'Association culturelle',
                'description' => 'Association locale repérée dans une publication publique officielle. Elle donne au site une base sérieuse pour démarrer un annuaire des structures de Bazma, à compléter avec les responsables locaux.',
                'descriptionEn' => 'Local association identified in an official public publication. It gives the website a solid starting point for a Bazma local directory, to be completed with local representatives.',
                'descriptionAr' => 'جمعية محلية مذكورة في منشور عمومي رسمي. تمثل نقطة انطلاق جدية لبناء دليل هياكل بازمة مع استكمال المعطيات من المسؤولين المحليين.',
                'url' => 'https://pm.gov.tn/sites/default/files/2024-11/%D8%A8%D9%84%D8%A7%D8%BA%20%D8%AD%D9%88%D9%84%20%20%D8%A7%D9%84%D8%AA%D9%85%D9%88%D9%8A%D9%84%20%20%20%D8%A7%D9%84%D8%A3%D8%AC%D9%86%D8%A8%D9%8A%20.pdf',
                'image' => '/assets/bazma-memory.webp',
            ],
            [
                'name' => 'Association sportive Bazma',
                'nameEn' => 'Bazma Sports Association',
                'nameAr' => 'جمعية بازمة الرياضية',
                'type' => 'Sport',
                'description' => 'Trace sportive publique liée à Bazma, utile pour structurer les archives des équipes, matchs, photos, résultats et parcours des jeunes sportifs du village.',
                'descriptionEn' => 'Public sports trace linked to Bazma, useful for organizing archives of teams, matches, photos, results and youth sports journeys.',
                'descriptionAr' => 'أثر رياضي عمومي مرتبط ببازمة، مفيد لتنظيم أرشيف الفرق والمباريات والصور والنتائج ومسارات الشباب الرياضي.',
                'url' => 'https://www.ftf.org.tn/ar2/category/%D8%B1%D9%91%D8%A7%D8%A8%D8%B7%D8%A9-%D9%82%D8%A7%D8%A8%D8%B3/',
                'image' => '/assets/bazma-sport.webp',
            ],
            [
                'name' => 'Maison des jeunes de Bazma',
                'nameEn' => 'Bazma Youth Center',
                'nameAr' => 'دار الشباب بازمة',
                'type' => 'Structure jeunesse',
                'description' => 'Structure jeunesse centrale pour Bazma: activités, annonces, formations, rencontres et contenus à valider avec les responsables avant publication sur le site.',
                'descriptionEn' => 'A central youth structure for Bazma: activities, announcements, trainings, meetings and content to validate with the people in charge before publishing.',
                'descriptionAr' => 'هيكل شبابي أساسي في بازمة: أنشطة وإعلانات وتكوينات ولقاءات ومحتوى يجب التثبت منه مع المسؤولين قبل النشر.',
                'url' => 'https://www.facebook.com/p/%D8%AF%D8%A7%D8%B1-%D8%A7%D9%84%D8%B4%D8%A8%D8%A7%D8%A8-%D8%A8%D8%A7%D8%B2%D9%85%D8%A9-100089146635794/',
                'image' => '/assets/bazma-youth.webp',
            ],
            [
                'name' => 'Initiatives jeunesse à Bazma',
                'nameEn' => 'Youth initiatives in Bazma',
                'nameAr' => 'مبادرات شبابية في بازمة',
                'type' => 'Projet jeunesse',
                'description' => 'Des initiatives publiques mentionnent la Maison des jeunes de Bazma. Le CMS peut centraliser ces actions avec leurs dates, photos autorisées et liens sources.',
                'descriptionEn' => 'Public initiatives mention the Bazma youth center. The CMS can centralize these actions with dates, authorized photos and source links.',
                'descriptionAr' => 'تذكر مبادرات عمومية دار الشباب بازمة. يمكن لنظام الإدارة تجميع هذه الأنشطة مع التواريخ والصور المرخصة وروابط المصادر.',
                'url' => 'https://www.facebook.com/jeuness.eu4youth/videos/limitless-generation-a%CC%80-la-maison-des-jeunes-de-bazma-kebili/1015270436479405/',
                'image' => '/assets/bazma-youth.webp',
            ],
        ];

        foreach ($organizations as $position => $organization) {
            $this->em->persist((new CommunityOrganization())
                ->setName($organization['name'])
                ->setNameEn($organization['nameEn'])
                ->setNameAr($organization['nameAr'])
                ->setType($organization['type'])
                ->setDescription($organization['description'])
                ->setDescriptionEn($organization['descriptionEn'])
                ->setDescriptionAr($organization['descriptionAr'])
                ->setUrl($organization['url'])
                ->setImageUrl($organization['image'])
                ->setActive(true)
                ->setPosition($position + 1));
        }

        $images = [
            ['Bazma - oasis et terre', 'Bazma - oasis and land', 'بازمة - الواحة والأرض', '/assets/bazma-oasis.webp', 'Visuel éditorial de Bazma', 'https://www.facebook.com/AirportBazma/photos/'],
            ['Bazma - jeunesse', 'Bazma - youth', 'بازمة - الشباب', '/assets/bazma-youth.webp', 'Référence: دار الشباب بازمة - demander autorisation pour photos', 'https://www.facebook.com/p/%D8%AF%D8%A7%D8%B1-%D8%A7%D9%84%D8%B4%D8%A8%D8%A7%D8%A8-%D8%A8%D8%A7%D8%B2%D9%85%D8%A9-100089146635794/'],
            ['Bazma - traditions et chevaux', 'Bazma - traditions and horses', 'بازمة - التقاليد والخيول', '/assets/bazma-horses.webp', 'Référence: Camera Andalib - photos à autoriser', 'https://www.facebook.com/andalibstudio/posts/%D8%A8%D8%B9%D8%B6-%D9%85%D9%86-%D8%A7%D9%84%D8%B5%D9%88%D8%B1-%D9%84%D9%85%D9%88%D8%A7%D9%83%D8%A8%D8%A9-%D9%83%D8%A7%D9%85%D9%8A%D8%B1%D8%A7-%D8%A7%D9%84%D8%B9%D9%86%D8%AF%D9%84%D9%8A%D8%A8-%D9%84%D8%B9%D8%B4%D9%88%D9%8A%D8%A9-%D8%A7%D9%84%D8%AE%D9%8A%D9%84-%D8%AB%D8%A7%D9%86%D9%8A-%D8%A7%D9%84%D8%B9%D9%8A%D8%AF-%D9%82%D8%B1%D9%8A%D8%A9-%D8%A8%D8%A7%D8%B2%D9%85%D8%A9%D9%82%D8%A8%D9%84%D9%8A/1543426467143094/'],
            ['Bazma - sport', 'Bazma - sport', 'بازمة - الرياضة', '/assets/bazma-sport.webp', 'Référence: publications sportives publiques autour de Bazma', 'https://www.facebook.com/commune.kebili/posts/%D8%B5%D9%88%D8%B1-%D9%85%D9%86-%D9%85%D8%A8%D8%A7%D8%B1%D8%A7%D8%A9-%D8%A8%D8%A7%D8%B2%D9%85%D8%A9-%D9%88-%D8%A7%D9%84%D8%B1%D8%AD%D9%85%D8%A7%D8%AA-%D9%8A%D9%88%D9%85-%D8%A7%D9%85%D8%B3-%D8%A8%D8%A7%D9%84%D9%85%D9%84%D8%B9%D8%A8-%D8%A7%D9%84%D8%A8%D9%84%D8%AF%D9%8A-%D8%A7%D9%84%D9%87%D8%A7%D8%AF%D9%8A-%D8%A7%D9%84%D8%AF%D9%88%D9%81-%D8%A7%D9%84%D9%86%D8%B2%D9%84%D8%A9-%D9%82%D8%A8%D9%84%D9%8A-%D8%B6%D9%85/2912977192098679/'],
            ['Bazma - mémoire', 'Bazma - memory', 'بازمة - الذاكرة', '/assets/bazma-memory.webp', 'Référence: Bazma بازمة حكاية بلد bazma 2', 'https://www.facebook.com/p/Bazma-%D8%A8%D8%A7%D8%B2%D9%85%D8%A9-%D8%AD%D9%83%D8%A7%D9%8A%D8%A9-%D8%A8%D9%84%D8%AF-bazma-2-100071547231876/'],
            ['Bazma - espace public', 'Bazma - public space', 'بازمة - الفضاء العام', '/assets/bazma-airport.webp', 'Référence: Airport kebili-Bazma', 'https://www.facebook.com/AirportBazma/'],
        ];

        foreach ($images as $position => [$title, $titleEn, $titleAr, $url, $credit, $source]) {
            $this->em->persist((new GalleryImage())
                ->setTitle($title)
                ->setTitleEn($titleEn)
                ->setTitleAr($titleAr)
                ->setImageUrl($url)
                ->setCredit($credit)
                ->setSourceUrl($source)
                ->setPosition($position + 1)
                ->setFeatured(true));
        }

        $events = [
            ['Collecte officielle des photos de Bazma', 'Official Bazma photo collection', 'جمع رسمي لصور بازمة', null, 'Contacter les pages Facebook locales et les familles pour récupérer des images autorisées du village.', 'Contact local Facebook pages and families to collect authorized images of the village.', 'التواصل مع صفحات فيسبوك المحلية والعائلات لجمع صور مرخصة للقرية.'],
            ['Archive Maison des jeunes Bazma', 'Bazma youth center archive', 'أرشيف دار الشباب بازمة', null, 'Créer une archive des activités, annonces, formations et photos validées par دار الشباب بازمة.', 'Create an archive of activities, announcements, trainings and photos approved by دار الشباب بازمة.', 'إنشاء أرشيف للأنشطة والإعلانات والتكوينات والصور المصادق عليها من دار الشباب بازمة.'],
            ['Mémoire sportive de Bazma', 'Bazma sports memory', 'الذاكرة الرياضية لبازمة', null, 'Rassembler photos, noms d’équipes, résultats et publications sportives liées à Bazma.', 'Gather photos, team names, results and sports posts linked to Bazma.', 'جمع الصور وأسماء الفرق والنتائج والمنشورات الرياضية المرتبطة ببازمة.'],
        ];

        $eventCategories = ['Photos', 'Jeunesse', 'Sport'];
        $eventSources = [
            'https://www.facebook.com/AirportBazma/photos/',
            'https://www.facebook.com/p/%D8%AF%D8%A7%D8%B1-%D8%A7%D9%84%D8%B4%D8%A8%D8%A7%D8%A8-%D8%A8%D8%A7%D8%B2%D9%85%D8%A9-100089146635794/',
            'https://www.ftf.org.tn/ar2/category/%D8%B1%D9%91%D8%A7%D8%A8%D8%B7%D8%A9-%D9%82%D8%A7%D8%A8%D8%B3/',
        ];

        foreach ($events as $position => [$title, $titleEn, $titleAr, $date, $description, $descriptionEn, $descriptionAr]) {
            $this->em->persist((new Event())
                ->setTitle($title)
                ->setTitleEn($titleEn)
                ->setTitleAr($titleAr)
                ->setSlug('actualite-'.($position + 1))
                ->setEventDate($date)
                ->setLocation('Bazma')
                ->setCategory($eventCategories[$position] ?? 'Actualite')
                ->setSourceUrl($eventSources[$position] ?? null)
                ->setImageUrl(['/assets/bazma-airport.webp', '/assets/bazma-youth.webp', '/assets/bazma-sport.webp'][$position] ?? '/assets/bazma-memory.webp')
                ->setExcerpt($description)
                ->setExcerptEn($descriptionEn)
                ->setExcerptAr($descriptionAr)
                ->setDescription($description)
                ->setDescriptionEn($descriptionEn)
                ->setDescriptionAr($descriptionAr)
                ->setFeatured(true)
                ->setPosition($position + 2)
                ->setPublished(true));
        }

        $this->em->persist((new Event())
            ->setTitle('Dossier associations de Bazma')
            ->setTitleEn('Bazma associations file')
            ->setTitleAr('ملف جمعيات بازمة')
            ->setEventDate(new \DateTime('2026-06-12'))
            ->setLocation('Bazma')
            ->setCategory('Associations')
            ->setSourceUrl('https://pm.gov.tn/sites/default/files/2024-11/%D8%A8%D9%84%D8%A7%D8%BA%20%D8%AD%D9%88%D9%84%20%20%D8%A7%D9%84%D8%AA%D9%85%D9%88%D9%8A%D9%84%20%20%20%D8%A7%D9%84%D8%A3%D8%AC%D9%86%D8%A8%D9%8A%20.pdf')
            ->setDescription('Première base CMS pour les associations et structures repérées à Bazma, avec liens sources et vérification locale à compléter.')
            ->setDescriptionEn('First CMS base for associations and structures identified in Bazma, with source links and local verification to complete.')
            ->setDescriptionAr('قاعدة أولية داخل نظام الإدارة للجمعيات والهياكل التي تم رصدها في بازمة، مع روابط المصادر واستكمال التثبت محليا.')
            ->setFeatured(true)
            ->setPosition(1)
            ->setPublished(true));

        $this->em->flush();
        $output->writeln('Contenu initial charge.');

        return Command::SUCCESS;
    }
}
