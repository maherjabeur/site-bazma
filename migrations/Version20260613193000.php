<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260613193000 extends AbstractMigration
{
    private const DATA = array (
  'admin_user' => 
  array (
    'columns' => 
    array (
      0 => 'id',
      1 => 'email',
      2 => 'name',
      3 => 'roles',
      4 => 'password',
      5 => 'active',
    ),
    'rows' => 
    array (
      0 => 
      array (
        0 => 1,
        1 => 'maherjabeur@gmail.com',
        2 => 'Administrateur',
        3 => '["ROLE_SUPER_ADMIN"]',
        4 => '$2y$13$odBv6jR00kGjXZP76E.rJ./AgWRHr620GQgViJdTkNgWt906GX9vO',
        5 => true,
      ),
    ),
  ),
  'community_organization' => 
  array (
    'columns' => 
    array (
      0 => 'id',
      1 => 'name',
      2 => 'name_en',
      3 => 'name_ar',
      4 => 'type',
      5 => 'description',
      6 => 'description_en',
      7 => 'description_ar',
      8 => 'url',
      9 => 'image_url',
      10 => 'active',
      11 => 'position',
    ),
    'rows' => 
    array (
      0 => 
      array (
        0 => 5,
        1 => 'Association Bazma culture, tourisme et loisirs',
        2 => 'Bazma Association for Culture, Tourism and Leisure',
        3 => 'جمعية بازمة للثقافة والسياحة والترفيه',
        4 => 'Association culturelle',
        5 => 'Association locale repérée dans une publication publique officielle. Elle donne au site une base sérieuse pour démarrer un annuaire des structures de Bazma, à compléter avec les responsables locaux.',
        6 => 'Local association identified in an official public publication. It gives the website a solid starting point for a Bazma local directory, to be completed with local representatives.',
        7 => 'جمعية محلية مذكورة في منشور عمومي رسمي. تمثل نقطة انطلاق جدية لبناء دليل هياكل بازمة مع استكمال المعطيات من المسؤولين المحليين.',
        8 => 'https://pm.gov.tn/sites/default/files/2024-11/%D8%A8%D9%84%D8%A7%D8%BA%20%D8%AD%D9%88%D9%84%20%20%D8%A7%D9%84%D8%AA%D9%85%D9%88%D9%8A%D9%84%20%20%20%D8%A7%D9%84%D8%A3%D8%AC%D9%86%D8%A8%D9%8A%20.pdf',
        9 => '/assets/bazma-memory.webp',
        10 => true,
        11 => 1,
      ),
      1 => 
      array (
        0 => 6,
        1 => 'Association sportive Bazma',
        2 => 'Bazma Sports Association',
        3 => 'جمعية بازمة الرياضية',
        4 => 'Sport',
        5 => 'Trace sportive publique liée à Bazma, utile pour structurer les archives des équipes, matchs, photos, résultats et parcours des jeunes sportifs du village.',
        6 => 'Public sports trace linked to Bazma, useful for organizing archives of teams, matches, photos, results and youth sports journeys.',
        7 => 'أثر رياضي عمومي مرتبط ببازمة، مفيد لتنظيم أرشيف الفرق والمباريات والصور والنتائج ومسارات الشباب الرياضي.',
        8 => 'https://www.ftf.org.tn/ar2/category/%D8%B1%D9%91%D8%A7%D8%A8%D8%B7%D8%A9-%D9%82%D8%A7%D8%A8%D8%B3/',
        9 => '/assets/bazma-sport.webp',
        10 => true,
        11 => 2,
      ),
      2 => 
      array (
        0 => 7,
        1 => 'Maison des jeunes de Bazma',
        2 => 'Bazma Youth Center',
        3 => 'دار الشباب بازمة',
        4 => 'Structure jeunesse',
        5 => 'Structure jeunesse centrale pour Bazma: activités, annonces, formations, rencontres et contenus à valider avec les responsables avant publication sur le site.',
        6 => 'A central youth structure for Bazma: activities, announcements, trainings, meetings and content to validate with the people in charge before publishing.',
        7 => 'هيكل شبابي أساسي في بازمة: أنشطة وإعلانات وتكوينات ولقاءات ومحتوى يجب التثبت منه مع المسؤولين قبل النشر.',
        8 => 'https://www.facebook.com/p/%D8%AF%D8%A7%D8%B1-%D8%A7%D9%84%D8%B4%D8%A8%D8%A7%D8%A8-%D8%A8%D8%A7%D8%B2%D9%85%D8%A9-100089146635794/',
        9 => '/assets/bazma-youth.webp',
        10 => true,
        11 => 3,
      ),
      3 => 
      array (
        0 => 8,
        1 => 'Initiatives jeunesse à Bazma',
        2 => 'Youth initiatives in Bazma',
        3 => 'مبادرات شبابية في بازمة',
        4 => 'Projet jeunesse',
        5 => 'Des initiatives publiques mentionnent la Maison des jeunes de Bazma. Le CMS peut centraliser ces actions avec leurs dates, photos autorisées et liens sources.',
        6 => 'Public initiatives mention the Bazma youth center. The CMS can centralize these actions with dates, authorized photos and source links.',
        7 => 'تذكر مبادرات عمومية دار الشباب بازمة. يمكن لنظام الإدارة تجميع هذه الأنشطة مع التواريخ والصور المرخصة وروابط المصادر.',
        8 => 'https://www.facebook.com/jeuness.eu4youth/videos/limitless-generation-a%CC%80-la-maison-des-jeunes-de-bazma-kebili/1015270436479405/',
        9 => '/assets/bazma-youth.webp',
        10 => true,
        11 => 4,
      ),
    ),
  ),
  'event' => 
  array (
    'columns' => 
    array (
      0 => 'id',
      1 => 'title',
      2 => 'event_date',
      3 => 'location',
      4 => 'description',
      5 => 'published',
      6 => 'title_en',
      7 => 'title_ar',
      8 => 'description_en',
      9 => 'description_ar',
      10 => 'category',
      11 => 'source_url',
      12 => 'featured',
      13 => 'position',
      14 => 'slug',
      15 => 'image_url',
      16 => 'excerpt',
      17 => 'excerpt_en',
      18 => 'excerpt_ar',
    ),
    'rows' => 
    array (
      0 => 
      array (
        0 => 22,
        1 => 'Collecte officielle des photos de Bazma',
        2 => NULL,
        3 => 'Bazma',
        4 => 'Contacter les pages Facebook locales et les familles pour récupérer des images autorisées du village.',
        5 => true,
        6 => 'Official Bazma photo collection',
        7 => 'جمع رسمي لصور بازمة',
        8 => 'Contact local Facebook pages and families to collect authorized images of the village.',
        9 => 'التواصل مع صفحات فيسبوك المحلية والعائلات لجمع صور مرخصة للقرية.',
        10 => 'Photos',
        11 => 'https://www.facebook.com/AirportBazma/photos/',
        12 => false,
        13 => 22,
        14 => 'actualite-22-collecte-officielle-des-photos-de-bazma',
        15 => NULL,
        16 => NULL,
        17 => NULL,
        18 => NULL,
      ),
      1 => 
      array (
        0 => 23,
        1 => 'Archive Maison des jeunes Bazma',
        2 => NULL,
        3 => 'Bazma',
        4 => 'Créer une archive des activités, annonces, formations et photos validées par دار الشباب بازمة.',
        5 => true,
        6 => 'Bazma youth center archive',
        7 => 'أرشيف دار الشباب بازمة',
        8 => 'Create an archive of activities, announcements, trainings and photos approved by دار الشباب بازمة.',
        9 => 'إنشاء أرشيف للأنشطة والإعلانات والتكوينات والصور المصادق عليها من دار الشباب بازمة.',
        10 => 'Jeunesse',
        11 => 'https://www.facebook.com/p/%D8%AF%D8%A7%D8%B1-%D8%A7%D9%84%D8%B4%D8%A8%D8%A7%D8%A8-%D8%A8%D8%A7%D8%B2%D9%85%D8%A9-100089146635794/',
        12 => false,
        13 => 23,
        14 => 'actualite-23-archive-maison-des-jeunes-bazma',
        15 => NULL,
        16 => NULL,
        17 => NULL,
        18 => NULL,
      ),
      2 => 
      array (
        0 => 24,
        1 => 'Mémoire sportive de Bazma',
        2 => NULL,
        3 => 'Bazma',
        4 => 'Rassembler photos, noms d’équipes, résultats et publications sportives liées à Bazma.',
        5 => true,
        6 => 'Bazma sports memory',
        7 => 'الذاكرة الرياضية لبازمة',
        8 => 'Gather photos, team names, results and sports posts linked to Bazma.',
        9 => 'جمع الصور وأسماء الفرق والنتائج والمنشورات الرياضية المرتبطة ببازمة.',
        10 => 'Sport',
        11 => 'https://www.ftf.org.tn/ar2/category/%D8%B1%D9%91%D8%A7%D8%A8%D8%B7%D8%A9-%D9%82%D8%A7%D8%A8%D8%B3/',
        12 => false,
        13 => 24,
        14 => 'actualite-24-mémoire-sportive-de-bazma',
        15 => NULL,
        16 => NULL,
        17 => NULL,
        18 => NULL,
      ),
      3 => 
      array (
        0 => 25,
        1 => 'Dossier associations de Bazma',
        2 => '2026-06-12',
        3 => 'Bazma',
        4 => 'Première base CMS pour les associations et structures repérées à Bazma, avec liens sources et vérification locale à compléter.',
        5 => true,
        6 => 'Bazma associations file',
        7 => 'ملف جمعيات بازمة',
        8 => 'First CMS base for associations and structures identified in Bazma, with source links and local verification to complete.',
        9 => 'قاعدة أولية داخل نظام الإدارة للجمعيات والهياكل التي تم رصدها في بازمة، مع روابط المصادر واستكمال التثبت محليا.',
        10 => 'Associations',
        11 => 'https://pm.gov.tn/sites/default/files/2024-11/%D8%A8%D9%84%D8%A7%D8%BA%20%D8%AD%D9%88%D9%84%20%20%D8%A7%D9%84%D8%AA%D9%85%D9%88%D9%8A%D9%84%20%20%20%D8%A7%D9%84%D8%A3%D8%AC%D9%86%D8%A8%D9%8A%20.pdf',
        12 => false,
        13 => 21,
        14 => 'actualite-25-dossier-associations-de-bazma',
        15 => NULL,
        16 => NULL,
        17 => NULL,
        18 => NULL,
      ),
      4 => 
      array (
        0 => 26,
        1 => 'Collecte officielle des photos de Bazma',
        2 => '2026-06-12',
        3 => 'Bazma',
        4 => 'Le site Bazma ouvre une collecte éditoriale dédiée aux images du village. L\'objectif est de publier uniquement des photos autorisées, correctement créditées et utiles à la mémoire locale.

Chaque contribution pourra être ajoutée depuis le CMS avec son titre, sa légende, son auteur, son lien source et son contexte.',
        5 => true,
        6 => 'Official Bazma photo collection',
        7 => 'جمع رسمي لصور بازمة',
        8 => 'The Bazma website is opening an editorial collection dedicated to village images. The goal is to publish only authorized photos, properly credited and useful to local memory.

Each contribution can be added through the CMS with its title, caption, author, source link and context.',
        9 => 'يفتح موقع بازمة جمعا تحريريا مخصصا لصور القرية. الهدف هو نشر صور مرخصة فقط، مع ذكر صاحب الصورة والسياق والمصدر.

يمكن إضافة كل مساهمة من نظام الإدارة مع العنوان والتعليق والرابط والمعلومات المحلية.',
        10 => 'Mémoire',
        11 => NULL,
        12 => true,
        13 => 1,
        14 => 'actualite-photos-bazma',
        15 => '/assets/bazma-memory.webp',
        16 => 'Un appel à contribution pour réunir des photos autorisées du village, avec crédit, date, lieu et lien source.',
        17 => 'A contribution call to gather authorized village photos with credit, date, place and source link.',
        18 => 'دعوة لجمع صور مرخصة للقرية مع الاعتماد والتاريخ والمكان ورابط المصدر.',
      ),
      5 => 
      array (
        0 => 27,
        1 => 'La Maison des jeunes au coeur de l’archive locale',
        2 => '2026-06-10',
        3 => 'Maison des jeunes de Bazma',
        4 => 'Le CMS permet de transformer les activités locales en actualités lisibles: image de couverture, résumé court, contenu complet, date, catégorie et lien source.

Cette structure aide à suivre les projets jeunesse et à garder une trace claire des moments importants pour Bazma.',
        5 => true,
        6 => 'The youth center at the heart of the local archive',
        7 => 'دار الشباب في قلب الأرشيف المحلي',
        8 => 'The CMS turns local activities into readable news: cover image, short summary, full story, date, category and source link.

This structure helps follow youth projects and keep a clear record of important moments for Bazma.',
        9 => 'يسمح نظام الإدارة بتحويل الأنشطة المحلية إلى أخبار واضحة: صورة رئيسية، ملخص قصير، نص كامل، تاريخ، صنف ورابط مصدر.

يساعد ذلك على متابعة مشاريع الشباب وحفظ لحظات مهمة لبازمة.',
        10 => 'Jeunesse',
        11 => NULL,
        12 => true,
        13 => 2,
        14 => 'actualite-maison-jeunes-bazma',
        15 => '/assets/bazma-youth.webp',
        16 => 'Activités, annonces, formations et événements jeunesse peuvent maintenant être structurés comme de vraies actualités.',
        17 => 'Activities, announcements, trainings and youth events can now be structured as real news stories.',
        18 => 'يمكن الآن تنظيم الأنشطة والإعلانات والتكوينات وتظاهرات الشباب كأخبار حقيقية.',
      ),
      6 => 
      array (
        0 => 28,
        1 => 'Sport à Bazma: matchs, équipes et mémoire collective',
        2 => '2026-06-08',
        3 => 'Bazma',
        4 => 'Les actualités sportives peuvent devenir une archive vivante: chaque match, tournoi, académie ou réussite locale peut être publié avec une image, une source et une date.

Le but est de construire une mémoire sportive locale propre, consultable et facile à enrichir.',
        5 => true,
        6 => 'Sport in Bazma: matches, teams and shared memory',
        7 => 'الرياضة في بازمة: مباريات وفرق وذاكرة مشتركة',
        8 => 'Sports news can become a living archive: every match, tournament, academy moment or local success can be published with an image, source and date.

The goal is to build a clean local sports memory that is easy to browse and enrich.',
        9 => 'يمكن أن تصبح الأخبار الرياضية أرشيفا حيا: كل مقابلة أو دورة أو نجاح محلي يمكن نشره بصورة ومصدر وتاريخ.

الهدف هو بناء ذاكرة رياضية محلية واضحة وسهلة الإثراء.',
        10 => 'Sport',
        11 => NULL,
        12 => true,
        13 => 3,
        14 => 'actualite-sport-bazma',
        15 => '/assets/bazma-sport.webp',
        16 => 'Une rubrique pour documenter les équipes, les résultats, les photos de matchs et les parcours des jeunes sportifs.',
        17 => 'A section to document teams, results, match photos and youth sports journeys.',
        18 => 'قسم لتوثيق الفرق والنتائج وصور المباريات ومسارات الشباب الرياضي.',
      ),
      7 => 
      array (
        0 => 29,
        1 => 'Un annuaire vivant pour les associations de Bazma',
        2 => '2026-06-06',
        3 => 'Bazma',
        4 => 'Les associations et structures locales disposent maintenant d’un espace clair dans le CMS. Une fiche peut contenir un type, une description multilingue, une image et un lien source.

Les actualités permettent ensuite de raconter les actions importantes menées autour de Bazma.',
        5 => true,
        6 => 'A living directory for Bazma associations',
        7 => 'دليل حي لجمعيات بازمة',
        8 => 'Local associations and structures now have a clear space in the CMS. A profile can include a type, multilingual description, image and source link.

News stories can then highlight important actions around Bazma.',
        9 => 'أصبحت للجمعيات والهياكل المحلية مساحة واضحة في نظام الإدارة. يمكن أن تحتوي البطاقة على النوع والوصف متعدد اللغات والصورة ورابط المصدر.

ثم تسمح الأخبار بعرض الأعمال المهمة حول بازمة.',
        10 => 'Associations',
        11 => NULL,
        12 => true,
        13 => 4,
        14 => 'actualite-associations-bazma',
        15 => '/assets/bazma-airport.webp',
        16 => 'Le site peut présenter les structures locales avec description, photo, lien source et statut de visibilité.',
        17 => 'The site can present local structures with description, photo, source link and visibility status.',
        18 => 'يمكن للموقع عرض الهياكل المحلية مع الوصف والصورة ورابط المصدر وحالة الظهور.',
      ),
    ),
  ),
  'gallery_image' => 
  array (
    'columns' => 
    array (
      0 => 'id',
      1 => 'title',
      2 => 'image_url',
      3 => 'credit',
      4 => 'source_url',
      5 => 'featured',
      6 => 'position',
      7 => 'title_en',
      8 => 'title_ar',
    ),
    'rows' => 
    array (
      0 => 
      array (
        0 => 47,
        1 => 'Bazma - oasis et terre',
        2 => '/assets/bazma-oasis.webp',
        3 => 'Visuel local provisoire - remplacer par une photo autorisée de Bazma',
        4 => 'https://www.facebook.com/AirportBazma/photos/',
        5 => true,
        6 => 1,
        7 => 'Bazma - oasis and land',
        8 => 'بازمة - الواحة والأرض',
      ),
      1 => 
      array (
        0 => 48,
        1 => 'Bazma - jeunesse',
        2 => '/assets/bazma-youth.webp',
        3 => 'Référence: دار الشباب بازمة - demander autorisation pour photos',
        4 => 'https://www.facebook.com/p/%D8%AF%D8%A7%D8%B1-%D8%A7%D9%84%D8%B4%D8%A8%D8%A7%D8%A8-%D8%A8%D8%A7%D8%B2%D9%85%D8%A9-100089146635794/',
        5 => true,
        6 => 2,
        7 => 'Bazma - youth',
        8 => 'بازمة - الشباب',
      ),
      2 => 
      array (
        0 => 49,
        1 => 'Bazma - traditions et chevaux',
        2 => '/assets/bazma-horses.webp',
        3 => 'Référence: Camera Andalib - photos à autoriser',
        4 => 'https://www.facebook.com/andalibstudio/posts/%D8%A8%D8%B9%D8%B6-%D9%85%D9%86-%D8%A7%D9%84%D8%B5%D9%88%D8%B1-%D9%84%D9%85%D9%88%D8%A7%D9%83%D8%A8%D8%A9-%D9%83%D8%A7%D9%85%D9%8A%D8%B1%D8%A7-%D8%A7%D9%84%D8%B9%D9%86%D8%AF%D9%84%D9%8A%D8%A8-%D9%84%D8%B9%D8%B4',
        5 => true,
        6 => 3,
        7 => 'Bazma - traditions and horses',
        8 => 'بازمة - التقاليد والخيول',
      ),
      3 => 
      array (
        0 => 50,
        1 => 'Bazma - sport',
        2 => '/assets/bazma-sport.webp',
        3 => 'Référence: publications sportives publiques autour de Bazma',
        4 => 'https://www.facebook.com/commune.kebili/posts/%D8%B5%D9%88%D8%B1-%D9%85%D9%86-%D9%85%D8%A8%D8%A7%D8%B1%D8%A7%D8%A9-%D8%A8%D8%A7%D8%B2%D9%85%D8%A9-%D9%88-%D8%A7%D9%84%D8%B1%D8%AD%D9%85%D8%A7%D8%AA-%D9%8A%D9%88%D9%85-%D8%A7%D9%85%D8%B3-%D8%A8%D8%A7%D9%84%D9',
        5 => true,
        6 => 4,
        7 => 'Bazma - sport',
        8 => 'بازمة - الرياضة',
      ),
      4 => 
      array (
        0 => 51,
        1 => 'Bazma - mémoire',
        2 => '/assets/bazma-memory.webp',
        3 => 'Référence: Bazma بازمة حكاية بلد bazma 2',
        4 => 'https://www.facebook.com/p/Bazma-%D8%A8%D8%A7%D8%B2%D9%85%D8%A9-%D8%AD%D9%83%D8%A7%D9%8A%D8%A9-%D8%A8%D9%84%D8%AF-bazma-2-100071547231876/',
        5 => true,
        6 => 5,
        7 => 'Bazma - memory',
        8 => 'بازمة - الذاكرة',
      ),
      5 => 
      array (
        0 => 52,
        1 => 'Bazma - espace public',
        2 => '/assets/bazma-airport.webp',
        3 => 'Référence: Airport kebili-Bazma',
        4 => 'https://www.facebook.com/AirportBazma/',
        5 => true,
        6 => 6,
        7 => 'Bazma - public space',
        8 => 'بازمة - الفضاء العام',
      ),
    ),
  ),
  'page' => 
  array (
    'columns' => 
    array (
      0 => 'id',
      1 => 'title',
      2 => 'slug',
      3 => 'summary',
      4 => 'body',
      5 => 'image_url',
      6 => 'published',
      7 => 'position',
      8 => 'title_en',
      9 => 'title_ar',
      10 => 'summary_en',
      11 => 'summary_ar',
      12 => 'body_en',
      13 => 'body_ar',
    ),
    'rows' => 
    array (
      0 => 
      array (
        0 => 39,
        1 => 'Bazma en bref',
        2 => 'bazma-en-bref',
        3 => 'Bazma est un village oasien de la délégation de Kébili Sud, avec une identité locale forte.',
        4 => '<p>Bazma est située près de Kébili, dans le Sud tunisien. Les sources géographiques publiques la placent autour de 33.66583 N et 9.01167 E. Ce site doit rester centré sur Bazma seulement: ses habitants, ses lieux, son oasis, sa jeunesse, ses photos et ses archives.</p><figure class="" data-size="50" data-align="wrap-left"><img src="/assets/bazma-airport.webp" alt="Bazma - espace public - Référence: Airport kebili-Bazma"><figcaption>Bazma - espace public - Référence: Airport kebili-Bazma</figcaption></figure><p><br></p><p>Le contenu initial combine des sources publiques classiques et des traces sociales visibles sur Facebook. Les photos exactes de Bazma repérées sur les réseaux ne sont pas copiées sans autorisation: elles sont référencées pour contacter les auteurs, demander l\'accord, puis ajouter les images avec crédit dans le CMS.</p><p><br></p><figure data-size="100" data-align="center"><video controls="" playsinline="" preload="metadata" src="/uploads/videos/editeur-15046073-3240-2160-60fps-8e93255d9a.mp4"></video><figcaption>Video</figcaption></figure><p><br></p><p><br></p>',
        5 => '/assets/bazma-oasis.webp',
        6 => true,
        7 => 1,
        8 => 'Bazma at a glance',
        9 => 'بازمة في لمحة',
        10 => 'Bazma is an oasis village in the Kebili South delegation, with a strong local identity.',
        11 => 'بازمة قرية واحية من معتمدية قبلي الجنوبية، ولها هوية محلية واضحة.',
        12 => '<p>Bazma is located near Kebili in southern Tunisia. Public geographic sources place it around 33.66583 N and 9.01167 E. This website must stay focused only on Bazma: its people, places, oasis, youth, photos and archives.</p><p>The starter content combines public reference sources and social traces visible on Facebook. Exact Bazma photos found on social media are not copied without permission: they are referenced so authors can be contacted, permission requested and credited photos added through the CMS.</p>',
        13 => '<p>تقع بازمة قرب قبلي في الجنوب التونسي. وتضعها المصادر الجغرافية العامة حول الإحداثيات 33.66583 شمالا و9.01167 شرقا. يجب أن يبقى هذا الموقع مخصصا لبازمة فقط: أهلها، أماكنها، واحتها، شبابها، صورها وأرشيفها.</p><p>يمزج المحتوى الأولي بين مصادر عامة وآثار اجتماعية منشورة على فيسبوك. لا يتم نسخ صور بازمة الدقيقة من الشبكات دون إذن، بل توضع الروابط للتواصل مع أصحابها وطلب الموافقة ثم إضافة الصور مع الاعتماد داخل نظام الإدارة.</p>',
      ),
      1 => 
      array (
        0 => 40,
        1 => 'Oasis, eau et terre',
        2 => 'oasis-eau-terre',
        3 => 'La mémoire de Bazma passe par son oasis, l’eau, les cultures et le travail de la terre.',
        4 => 'Le document FIES du ministère tunisien de l\'environnement mentionne l\'oasis de Bazma dans le cadre d\'un projet de réhabilitation du périmètre irrigué. La page arabe de Bazma signale aussi la réputation du village autour de la terre et des cultures maraîchères.

Cette page doit devenir un espace local: noms des parcelles, puits, souvenirs de récoltes, techniques d\'irrigation, anciennes photos d\'oasis et témoignages d\'agriculteurs.',
        5 => '/assets/bazma-oasis.webp',
        6 => true,
        7 => 2,
        8 => 'Oasis, water and land',
        9 => 'الواحة والماء والأرض',
        10 => 'Bazma’s memory runs through its oasis, water, crops and work on the land.',
        11 => 'تمر ذاكرة بازمة عبر الواحة والماء والزراعات وخدمة الأرض.',
        12 => 'The FIES document from the Tunisian Ministry of Environment mentions the Bazma oasis as part of an irrigated perimeter rehabilitation project. The Arabic page about Bazma also points to the village’s reputation for working the land and growing vegetables.

This page should become a local space: plot names, wells, harvest memories, irrigation practices, old oasis photos and farmers’ testimonies.',
        13 => 'تذكر وثيقة FIES لوزارة البيئة التونسية واحة بازمة ضمن مشروع إعادة تأهيل محيط سقوي. كما تشير الصفحة العربية الخاصة ببازمة إلى شهرة القرية بخدمة الأرض وغراسة الخضر.

يمكن أن تصبح هذه الصفحة فضاء محليا لأسماء القطع والآبار وذكريات الجني وتقنيات الري والصور القديمة للواحة وشهادات الفلاحين.',
      ),
      2 => 
      array (
        0 => 41,
        1 => 'Jeunesse et Maison des jeunes',
        2 => 'jeunesse-maison-des-jeunes',
        3 => 'Les publications de دار الشباب بازمة montrent une activité locale importante autour des jeunes.',
        4 => 'La page Facebook دار الشباب بازمة publie des annonces, activités, rencontres et contenus liés aux jeunes de Bazma. Des sources comme Jeun\'ESS / EU4Youth mentionnent aussi des initiatives à la Maison des jeunes de Bazma.

Le site doit référencer ces actions: orientation des élèves, activités culturelles, projets citoyens, formations, événements et photos validées par les responsables.',
        5 => '/assets/bazma-youth.webp',
        6 => true,
        7 => 3,
        8 => 'Youth and youth center',
        9 => 'الشباب ودار الشباب',
        10 => 'Posts from دار الشباب بازمة show important local activity around young people.',
        11 => 'تظهر منشورات دار الشباب بازمة نشاطا محليا مهما موجها للشباب.',
        12 => 'The دار الشباب بازمة Facebook page publishes announcements, activities, meetings and content linked to Bazma’s youth. Sources such as Jeun\'ESS / EU4Youth also mention initiatives at the Bazma youth center.

The website should reference these actions: student guidance, cultural activities, civic projects, trainings, events and photos approved by the people in charge.',
        13 => 'تنشر صفحة دار الشباب بازمة على فيسبوك إعلانات وأنشطة ولقاءات ومحتويات مرتبطة بشباب بازمة. كما تذكر مصادر مثل Jeun\'ESS / EU4Youth مبادرات في دار الشباب بازمة.

ينبغي أن يوثق الموقع هذه الأنشطة: توجيه التلاميذ، الأنشطة الثقافية، المشاريع المواطنة، التكوينات، التظاهرات والصور المصادق عليها من المسؤولين.',
      ),
      3 => 
      array (
        0 => 42,
        1 => 'Fêtes, chevaux et vie sociale',
        2 => 'fetes-chevaux-vie-sociale',
        3 => 'Des publications Facebook récentes documentent des moments de fête et de vie sociale à Bazma.',
        4 => 'Camera Andalib a publié des contenus autour de عشوية الخيل / ثاني العيد à قرية بازمة، قبلي. Ces contenus sont précieux pour raconter la vie sociale, les fêtes, les chevaux et les rassemblements.

Les images ne sont pas intégrées directement sans accord. La bonne procédure: contacter le studio ou l\'auteur, récupérer l\'image autorisée, indiquer le crédit, puis l\'ajouter dans la galerie du CMS.',
        5 => '/assets/bazma-horses.webp',
        6 => true,
        7 => 4,
        8 => 'Celebrations, horses and social life',
        9 => 'المناسبات والخيول والحياة الاجتماعية',
        10 => 'Recent Facebook posts document celebrations and social life moments in Bazma.',
        11 => 'توثق منشورات فيسبوك حديثة مناسبات ولحظات اجتماعية في بازمة.',
        12 => 'Camera Andalib published content around عشوية الخيل / ثاني العيد in قرية بازمة، قبلي. These posts are valuable for telling the story of social life, celebrations, horses and gatherings.

Images are not embedded directly without permission. The right process is to contact the studio or author, obtain the authorized image, add the credit and then upload it to the CMS gallery.',
        13 => 'نشرت كاميرا العندليب محتوى حول عشوية الخيل / ثاني العيد في قرية بازمة، قبلي. هذه المنشورات مهمة لتوثيق الحياة الاجتماعية والمناسبات والخيول والتجمعات.

لا تدرج الصور مباشرة دون إذن. الطريقة الصحيحة هي التواصل مع الاستوديو أو صاحب الصورة، الحصول على صورة مرخصة، ذكر الاعتماد ثم إضافتها إلى معرض نظام الإدارة.',
      ),
      4 => 
      array (
        0 => 43,
        1 => 'Sport et équipes de Bazma',
        2 => 'sport-equipes-bazma',
        3 => 'Facebook garde des traces de matchs, d’académies et de jeunes sportifs liés à Bazma.',
        4 => 'Des résultats de recherche montrent des publications sur des matchs impliquant Bazma, notamment une publication ancienne de la Commune de Kébili et des contenus récents autour d\'une académie de Bazma.

Cette page peut devenir l\'archive sportive du village: équipes, photos de matchs, noms des joueurs, résultats, tournois locaux, médailles et parcours des jeunes.',
        5 => '/assets/bazma-sport.webp',
        6 => true,
        7 => 5,
        8 => 'Sport and Bazma teams',
        9 => 'الرياضة وفرق بازمة',
        10 => 'Facebook keeps traces of matches, academies and young athletes linked to Bazma.',
        11 => 'يحفظ فيسبوك آثار مباريات وأكاديميات وشباب رياضيين مرتبطين ببازمة.',
        12 => 'Search results show posts about matches involving Bazma, including an older post from the Commune of Kebili and recent content around a Bazma academy.

This page can become the village sports archive: teams, match photos, player names, results, local tournaments, medals and youth journeys.',
        13 => 'تظهر نتائج البحث منشورات حول مباريات شاركت فيها بازمة، منها منشور قديم لبلدية قبلي ومحتويات حديثة حول أكاديمية بازمة.

يمكن أن تصبح هذه الصفحة أرشيفا رياضيا للقرية: الفرق، صور المباريات، أسماء اللاعبين، النتائج، الدورات المحلية، الميداليات ومسارات الشباب.',
      ),
      5 => 
      array (
        0 => 44,
        1 => 'Photos de Bazma: méthode de collecte',
        2 => 'photos-bazma-collecte',
        3 => 'Les vraies images de Bazma doivent venir des habitants, pages locales et publications Facebook autorisées.',
        4 => 'Sources prioritaires à contacter: Airport kebili-Bazma, دار الشباب بازمة, Bazma بازمة حكاية بلد bazma 2, Camera Andalib, pages sportives et publications publiques qui mentionnent قرية بازمة.

Avant publication: demander l\'accord, noter l\'auteur, la date, le lieu, la légende, le lien source et le niveau d\'autorisation. Ensuite, ajouter l\'image au CMS avec son crédit. Cette règle protège le site et respecte les habitants.',
        5 => '/assets/bazma-memory.webp',
        6 => true,
        7 => 6,
        8 => 'Bazma photos: collection method',
        9 => 'صور بازمة: طريقة الجمع',
        10 => 'Real Bazma images should come from residents, local pages and authorized Facebook posts.',
        11 => 'يجب أن تأتي صور بازمة الحقيقية من السكان والصفحات المحلية ومنشورات فيسبوك المرخصة.',
        12 => 'Priority sources to contact: Airport kebili-Bazma, دار الشباب بازمة, Bazma بازمة حكاية بلد bazma 2, Camera Andalib, sports pages and public posts mentioning قرية بازمة.

Before publication: ask permission, record author, date, place, caption, source link and permission level. Then add the image to the CMS with its credit. This rule protects the website and respects residents.',
        13 => 'مصادر ذات أولوية للتواصل: Airport kebili-Bazma، دار الشباب بازمة، Bazma بازمة حكاية بلد bazma 2، كاميرا العندليب، الصفحات الرياضية والمنشورات العامة التي تذكر قرية بازمة.

قبل النشر: طلب الإذن، تسجيل اسم صاحب الصورة، التاريخ، المكان، التعليق، رابط المصدر ومستوى الترخيص. بعد ذلك تضاف الصورة إلى نظام الإدارة مع الاعتماد. هذه القاعدة تحمي الموقع وتحترم أهل القرية.',
      ),
    ),
  ),
  'site_setting' => 
  array (
    'columns' => 
    array (
      0 => 'id',
      1 => 'setting_key',
      2 => 'setting_value',
    ),
    'rows' => 
    array (
      0 => 
      array (
        0 => 62,
        1 => 'site_title',
        2 => 'Bazma, mémoire vivante du village',
      ),
      1 => 
      array (
        0 => 63,
        1 => 'site_title_en',
        2 => 'Bazma, a living village memory',
      ),
      2 => 
      array (
        0 => 64,
        1 => 'site_title_ar',
        2 => 'بازمة، ذاكرة قرية حيّة',
      ),
      3 => 
      array (
        0 => 65,
        1 => 'site_intro',
        2 => 'Une vitrine dédiée uniquement à Bazma: oasis, familles, jeunesse, photos publiques, sports, fêtes et projets locaux.',
      ),
      4 => 
      array (
        0 => 66,
        1 => 'site_intro_en',
        2 => 'A showcase dedicated only to Bazma: oasis, families, youth, public photos, sports, celebrations and local projects.',
      ),
      5 => 
      array (
        0 => 67,
        1 => 'site_intro_ar',
        2 => 'واجهة مخصصة لبازمة فقط: الواحة، العائلات، الشباب، الصور المنشورة، الرياضة، المناسبات والمشاريع المحلية.',
      ),
      6 => 
      array (
        0 => 68,
        1 => 'seo_title_ar',
        2 => 'بازمة قبلي | ذاكرة القرية والصور والشبكات المحلية',
      ),
      7 => 
      array (
        0 => 69,
        1 => 'seo_title_fr',
        2 => 'Bazma Kebili | Mémoire, photos et réseaux du village',
      ),
      8 => 
      array (
        0 => 70,
        1 => 'seo_title_en',
        2 => 'Bazma Kebili | Village memory, photos and local networks',
      ),
      9 => 
      array (
        0 => 71,
        1 => 'seo_description_ar',
        2 => 'موقع بازمة قبلي لجمع ذاكرة القرية: الواحة، الأهالي، الصور المرخصة، دار الشباب، الرياضة، التقاليد وروابط فيسبوك المحلية.',
      ),
      10 => 
      array (
        0 => 72,
        1 => 'seo_description_fr',
        2 => 'Site Bazma Kebili pour collecter la mémoire du village: oasis, habitants, photos autorisées, Maison des jeunes, sport, traditions et liens Facebook locaux.',
      ),
      11 => 
      array (
        0 => 73,
        1 => 'seo_description_en',
        2 => 'Bazma Kebili website collecting village memory: oasis, people, authorized photos, youth center, sport, traditions and local Facebook links.',
      ),
      12 => 
      array (
        0 => 74,
        1 => 'og_image',
        2 => '/assets/bazma-hero.webp',
      ),
      13 => 
      array (
        0 => 75,
        1 => 'footer_text_ar',
        2 => 'ذاكرة حيّة لبازمة تُبنى مع الأهالي والمصادر المحلية المرخّصة.',
      ),
      14 => 
      array (
        0 => 76,
        1 => 'footer_text_fr',
        2 => 'Mémoire vivante de Bazma, construite avec les habitants et les sources locales autorisées.',
      ),
      15 => 
      array (
        0 => 77,
        1 => 'footer_text_en',
        2 => 'A living memory of Bazma, built with residents and authorized local sources.',
      ),
      16 => 
      array (
        0 => 78,
        1 => 'hero_image',
        2 => '/uploads/accueil-465681125-8865001523521068-7722625421484976979-n-1bf1152aad.webp',
      ),
      17 => 
      array (
        0 => 80,
        1 => 'hero_eyebrow_fr',
        2 => 'Village de Kebili',
      ),
      18 => 
      array (
        0 => 81,
        1 => 'hero_eyebrow_en',
        2 => 'Kebili village',
      ),
      19 => 
      array (
        0 => 82,
        1 => 'hero_eyebrow_ar',
        2 => 'قرية من قبلي',
      ),
      20 => 
      array (
        0 => 83,
        1 => 'hero_title_fr',
        2 => 'Bazma, mémoire vivante du village',
      ),
      21 => 
      array (
        0 => 84,
        1 => 'hero_title_en',
        2 => 'Bazma, a living village memory',
      ),
      22 => 
      array (
        0 => 85,
        1 => 'hero_title_ar',
        2 => 'بازمة، ذاكرة قرية حيّة',
      ),
      23 => 
      array (
        0 => 86,
        1 => 'hero_intro_fr',
        2 => 'Une vitrine dédiée à Bazma: oasis, familles, jeunesse, photos publiques, sport, fêtes et projets locaux.',
      ),
      24 => 
      array (
        0 => 87,
        1 => 'hero_intro_en',
        2 => 'A showcase dedicated to Bazma: oasis, families, youth, public photos, sport, celebrations and local projects.',
      ),
      25 => 
      array (
        0 => 88,
        1 => 'hero_intro_ar',
        2 => 'واجهة مخصصة لبازمة: الواحة، العائلات، الشباب، الصور، الرياضة، المناسبات والمشاريع المحلية.',
      ),
      26 => 
      array (
        0 => 89,
        1 => 'hero_primary_label_fr',
        2 => 'Découvrir',
      ),
      27 => 
      array (
        0 => 90,
        1 => 'hero_primary_label_en',
        2 => 'Explore',
      ),
      28 => 
      array (
        0 => 91,
        1 => 'hero_primary_label_ar',
        2 => 'اكتشف',
      ),
      29 => 
      array (
        0 => 92,
        1 => 'hero_primary_url',
        2 => '#decouvrir',
      ),
      30 => 
      array (
        0 => 93,
        1 => 'hero_secondary_label_fr',
        2 => 'Voir les images',
      ),
      31 => 
      array (
        0 => 94,
        1 => 'hero_secondary_label_en',
        2 => 'View images',
      ),
      32 => 
      array (
        0 => 95,
        1 => 'hero_secondary_label_ar',
        2 => 'شاهد الصور',
      ),
      33 => 
      array (
        0 => 96,
        1 => 'hero_secondary_url',
        2 => '/fr/gallery',
      ),
      34 => 
      array (
        0 => 97,
        1 => 'home_fact_1_value',
        2 => '33.66583, 9.01167',
      ),
      35 => 
      array (
        0 => 98,
        1 => 'home_fact_1_label_fr',
        2 => 'Coordonnées',
      ),
      36 => 
      array (
        0 => 99,
        1 => 'home_fact_1_label_en',
        2 => 'Coordinates',
      ),
      37 => 
      array (
        0 => 100,
        1 => 'home_fact_1_label_ar',
        2 => 'الإحداثيات',
      ),
      38 => 
      array (
        0 => 101,
        1 => 'home_fact_2_value',
        2 => '6-9 km',
      ),
      39 => 
      array (
        0 => 102,
        1 => 'home_fact_2_label_fr',
        2 => 'De Kebili',
      ),
      40 => 
      array (
        0 => 103,
        1 => 'home_fact_2_label_en',
        2 => 'From Kebili',
      ),
      41 => 
      array (
        0 => 104,
        1 => 'home_fact_2_label_ar',
        2 => 'من قبلي',
      ),
      42 => 
      array (
        0 => 105,
        1 => 'home_fact_3_value',
        2 => 'Oasis',
      ),
      43 => 
      array (
        0 => 106,
        1 => 'home_fact_3_label_fr',
        2 => 'Paysage local',
      ),
      44 => 
      array (
        0 => 107,
        1 => 'home_fact_3_label_en',
        2 => 'Local landscape',
      ),
      45 => 
      array (
        0 => 108,
        1 => 'home_fact_3_label_ar',
        2 => 'المشهد المحلي',
      ),
      46 => 
      array (
        0 => 109,
        1 => 'home_fact_4_value',
        2 => 'BWh',
      ),
      47 => 
      array (
        0 => 110,
        1 => 'home_fact_4_label_fr',
        2 => 'Climat aride',
      ),
      48 => 
      array (
        0 => 111,
        1 => 'home_fact_4_label_en',
        2 => 'Arid climate',
      ),
      49 => 
      array (
        0 => 112,
        1 => 'home_fact_4_label_ar',
        2 => 'مناخ جاف',
      ),
      50 => 
      array (
        0 => 113,
        1 => 'brand_fr',
        2 => 'Bazma Kebili',
      ),
      51 => 
      array (
        0 => 114,
        1 => 'brand_en',
        2 => 'Bazma Kebili',
      ),
      52 => 
      array (
        0 => 115,
        1 => 'brand_ar',
        2 => 'بازمة قبلي',
      ),
      53 => 
      array (
        0 => 116,
        1 => 'nav_home_fr',
        2 => 'Accueil',
      ),
      54 => 
      array (
        0 => 117,
        1 => 'nav_home_en',
        2 => 'Home',
      ),
      55 => 
      array (
        0 => 118,
        1 => 'nav_home_ar',
        2 => 'الرئيسية',
      ),
      56 => 
      array (
        0 => 119,
        1 => 'nav_discover_fr',
        2 => 'Découvrir',
      ),
      57 => 
      array (
        0 => 120,
        1 => 'nav_discover_en',
        2 => 'Discover',
      ),
      58 => 
      array (
        0 => 121,
        1 => 'nav_discover_ar',
        2 => 'اكتشف',
      ),
      59 => 
      array (
        0 => 122,
        1 => 'nav_gallery_fr',
        2 => 'Galerie',
      ),
      60 => 
      array (
        0 => 123,
        1 => 'nav_gallery_en',
        2 => 'Gallery',
      ),
      61 => 
      array (
        0 => 124,
        1 => 'nav_gallery_ar',
        2 => 'الصور',
      ),
      62 => 
      array (
        0 => 125,
        1 => 'nav_associations_fr',
        2 => 'Associations',
      ),
      63 => 
      array (
        0 => 126,
        1 => 'nav_associations_en',
        2 => 'Associations',
      ),
      64 => 
      array (
        0 => 127,
        1 => 'nav_associations_ar',
        2 => 'الجمعيات',
      ),
      65 => 
      array (
        0 => 128,
        1 => 'nav_social_fr',
        2 => 'Réseaux',
      ),
      66 => 
      array (
        0 => 129,
        1 => 'nav_social_en',
        2 => 'Social',
      ),
      67 => 
      array (
        0 => 130,
        1 => 'nav_social_ar',
        2 => 'الشبكات',
      ),
      68 => 
      array (
        0 => 131,
        1 => 'nav_news_fr',
        2 => 'Actualités',
      ),
      69 => 
      array (
        0 => 132,
        1 => 'nav_news_en',
        2 => 'News',
      ),
      70 => 
      array (
        0 => 133,
        1 => 'nav_news_ar',
        2 => 'الأخبار',
      ),
      71 => 
      array (
        0 => 134,
        1 => 'home_discover_eyebrow_fr',
        2 => 'Découvrir Bazma',
      ),
      72 => 
      array (
        0 => 135,
        1 => 'home_discover_eyebrow_en',
        2 => 'Discover Bazma',
      ),
      73 => 
      array (
        0 => 136,
        1 => 'home_discover_eyebrow_ar',
        2 => 'اكتشف بازمة',
      ),
      74 => 
      array (
        0 => 137,
        1 => 'home_discover_title_fr',
        2 => 'Un territoire à documenter avec ses habitants',
      ),
      75 => 
      array (
        0 => 138,
        1 => 'home_discover_title_en',
        2 => 'A place to document with its residents',
      ),
      76 => 
      array (
        0 => 139,
        1 => 'home_discover_title_ar',
        2 => 'قرية نوثقها مع أهلها',
      ),
      77 => 
      array (
        0 => 140,
        1 => 'home_images_eyebrow_fr',
        2 => 'Images',
      ),
      78 => 
      array (
        0 => 141,
        1 => 'home_images_eyebrow_en',
        2 => 'Images',
      ),
      79 => 
      array (
        0 => 142,
        1 => 'home_images_eyebrow_ar',
        2 => 'الصور',
      ),
      80 => 
      array (
        0 => 143,
        1 => 'home_images_title_fr',
        2 => 'Palmeraies, lumière du désert et vie locale',
      ),
      81 => 
      array (
        0 => 144,
        1 => 'home_images_title_en',
        2 => 'Palm groves, desert light and local life',
      ),
      82 => 
      array (
        0 => 145,
        1 => 'home_images_title_ar',
        2 => 'النخيل، ضوء الصحراء والحياة المحلية',
      ),
      83 => 
      array (
        0 => 146,
        1 => 'home_associations_eyebrow_fr',
        2 => 'Associations locales',
      ),
      84 => 
      array (
        0 => 147,
        1 => 'home_associations_eyebrow_en',
        2 => 'Local associations',
      ),
      85 => 
      array (
        0 => 148,
        1 => 'home_associations_eyebrow_ar',
        2 => 'الجمعيات المحلية',
      ),
      86 => 
      array (
        0 => 149,
        1 => 'home_associations_title_fr',
        2 => 'Associations et structures actives autour de Bazma',
      ),
      87 => 
      array (
        0 => 150,
        1 => 'home_associations_title_en',
        2 => 'Associations and active local structures around Bazma',
      ),
      88 => 
      array (
        0 => 151,
        1 => 'home_associations_title_ar',
        2 => 'جمعيات وهياكل نشطة حول بازمة',
      ),
      89 => 
      array (
        0 => 152,
        1 => 'home_associations_text_fr',
        2 => 'Cette liste peut être complétée depuis le CMS dès qu’une source fiable est disponible.',
      ),
      90 => 
      array (
        0 => 153,
        1 => 'home_associations_text_en',
        2 => 'This list can be completed from the CMS whenever a reliable source is available.',
      ),
      91 => 
      array (
        0 => 154,
        1 => 'home_associations_text_ar',
        2 => 'يمكن إكمال هذه القائمة من نظام الإدارة كلما توفر مصدر موثوق.',
      ),
      92 => 
      array (
        0 => 155,
        1 => 'home_social_eyebrow_fr',
        2 => 'Bazma sur les réseaux',
      ),
      93 => 
      array (
        0 => 156,
        1 => 'home_social_eyebrow_en',
        2 => 'Bazma on social media',
      ),
      94 => 
      array (
        0 => 157,
        1 => 'home_social_eyebrow_ar',
        2 => 'بازمة على الشبكات',
      ),
      95 => 
      array (
        0 => 158,
        1 => 'home_social_title_fr',
        2 => 'Les traces publiques de Bazma',
      ),
      96 => 
      array (
        0 => 159,
        1 => 'home_social_title_en',
        2 => 'Public traces of Bazma',
      ),
      97 => 
      array (
        0 => 160,
        1 => 'home_social_title_ar',
        2 => 'آثار بازمة المنشورة',
      ),
      98 => 
      array (
        0 => 161,
        1 => 'home_social_text_fr',
        2 => 'Liens vers les pages et publications publiques liées à Bazma, à valider avant reprise de photos.',
      ),
      99 => 
      array (
        0 => 162,
        1 => 'home_social_text_en',
        2 => 'Links to public pages and posts related to Bazma, to validate before reusing photos.',
      ),
      100 => 
      array (
        0 => 163,
        1 => 'home_social_text_ar',
        2 => 'روابط لصفحات ومنشورات عامة حول بازمة، مع التثبت قبل استعمال الصور.',
      ),
      101 => 
      array (
        0 => 164,
        1 => 'home_news_eyebrow_fr',
        2 => 'CMS local',
      ),
      102 => 
      array (
        0 => 165,
        1 => 'home_news_eyebrow_en',
        2 => 'Local CMS',
      ),
      103 => 
      array (
        0 => 166,
        1 => 'home_news_eyebrow_ar',
        2 => 'نظام محلي',
      ),
      104 => 
      array (
        0 => 167,
        1 => 'home_news_title_fr',
        2 => 'Une vitrine qui peut évoluer',
      ),
      105 => 
      array (
        0 => 168,
        1 => 'home_news_title_en',
        2 => 'A showcase that can evolve',
      ),
      106 => 
      array (
        0 => 169,
        1 => 'home_news_title_ar',
        2 => 'واجهة قابلة للتطور',
      ),
      107 => 
      array (
        0 => 170,
        1 => 'home_news_text_fr',
        2 => 'Pages, images, crédits, événements et textes importants sont administrables depuis un espace sécurisé.',
      ),
      108 => 
      array (
        0 => 171,
        1 => 'home_news_text_en',
        2 => 'Pages, images, credits, events and important texts are managed from a secure space.',
      ),
      109 => 
      array (
        0 => 172,
        1 => 'home_news_text_ar',
        2 => 'الصفحات والصور والاعتمادات والأحداث والنصوص المهمة تدار من فضاء آمن.',
      ),
      110 => 
      array (
        0 => 173,
        1 => 'read_more_fr',
        2 => 'Lire',
      ),
      111 => 
      array (
        0 => 174,
        1 => 'read_more_en',
        2 => 'Read',
      ),
      112 => 
      array (
        0 => 175,
        1 => 'read_more_ar',
        2 => 'اقرأ',
      ),
      113 => 
      array (
        0 => 176,
        1 => 'source_label_fr',
        2 => 'Source',
      ),
      114 => 
      array (
        0 => 177,
        1 => 'source_label_en',
        2 => 'Source',
      ),
      115 => 
      array (
        0 => 178,
        1 => 'source_label_ar',
        2 => 'المصدر',
      ),
      116 => 
      array (
        0 => 179,
        1 => 'news_source_label_fr',
        2 => 'Lire la source',
      ),
      117 => 
      array (
        0 => 180,
        1 => 'news_source_label_en',
        2 => 'Read source',
      ),
      118 => 
      array (
        0 => 181,
        1 => 'news_source_label_ar',
        2 => 'قراءة المصدر',
      ),
      119 => 
      array (
        0 => 182,
        1 => 'planned_label_fr',
        2 => 'À planifier',
      ),
      120 => 
      array (
        0 => 183,
        1 => 'planned_label_en',
        2 => 'Planned',
      ),
      121 => 
      array (
        0 => 184,
        1 => 'planned_label_ar',
        2 => 'قيد البرمجة',
      ),
      122 => 
      array (
        0 => 185,
        1 => 'no_news_fr',
        2 => 'Aucune actualité publiée',
      ),
      123 => 
      array (
        0 => 186,
        1 => 'no_news_en',
        2 => 'No published news',
      ),
      124 => 
      array (
        0 => 187,
        1 => 'no_news_ar',
        2 => 'لا توجد أخبار منشورة',
      ),
    ),
  ),
  'social_link' => 
  array (
    'columns' => 
    array (
      0 => 'id',
      1 => 'platform',
      2 => 'title',
      3 => 'title_en',
      4 => 'title_ar',
      5 => 'summary',
      6 => 'summary_en',
      7 => 'summary_ar',
      8 => 'url',
      9 => 'image_url',
      10 => 'category',
      11 => 'featured',
      12 => 'position',
    ),
    'rows' => 
    array (
      0 => 
      array (
        0 => 33,
        1 => 'Facebook',
        2 => 'Airport kebili-Bazma',
        3 => 'Airport kebili-Bazma',
        4 => 'Airport kebili-Bazma',
        5 => 'Page publique avec photos, albums, vidéos et publications autour de Bazma.',
        6 => 'Public page with photos, albums, videos and posts around Bazma.',
        7 => 'صفحة عامة تضم صورا وألبومات وفيديوهات ومنشورات حول بازمة.',
        8 => 'https://www.facebook.com/AirportBazma/',
        9 => '/assets/bazma-airport.webp',
        10 => 'Page',
        11 => true,
        12 => 1,
      ),
      1 => 
      array (
        0 => 34,
        1 => 'Facebook',
        2 => 'Photos Airport kebili-Bazma',
        3 => 'Airport kebili-Bazma photos',
        4 => 'صور Airport kebili-Bazma',
        5 => 'Albums publics à vérifier pour récupérer des images de Bazma avec accord.',
        6 => 'Public albums to review for Bazma images with permission.',
        7 => 'ألبومات عامة يمكن مراجعتها للحصول على صور بازمة بإذن.',
        8 => 'https://www.facebook.com/AirportBazma/photos/',
        9 => '/assets/bazma-airport.webp',
        10 => 'Photos',
        11 => true,
        12 => 2,
      ),
      2 => 
      array (
        0 => 35,
        1 => 'Facebook',
        2 => 'دار الشباب بازمة',
        3 => 'Bazma youth center',
        4 => 'دار الشباب بازمة',
        5 => 'Page Facebook locale liée aux activités, annonces et événements de la jeunesse à Bazma.',
        6 => 'Local Facebook page linked to youth activities, announcements and events in Bazma.',
        7 => 'صفحة محلية مرتبطة بأنشطة وإعلانات وتظاهرات الشباب في بازمة.',
        8 => 'https://www.facebook.com/p/%D8%AF%D8%A7%D8%B1-%D8%A7%D9%84%D8%B4%D8%A8%D8%A7%D8%A8-%D8%A8%D8%A7%D8%B2%D9%85%D8%A9-100089146635794/',
        9 => '/assets/bazma-youth.webp',
        10 => 'Jeunesse',
        11 => true,
        12 => 3,
      ),
      3 => 
      array (
        0 => 36,
        1 => 'Facebook',
        2 => 'Bazma بازمة حكاية بلد',
        3 => 'Bazma story page',
        4 => 'بازمة حكاية بلد',
        5 => 'Page sociale centrée sur des nouvelles, réussites et fragments de mémoire de Bazma.',
        6 => 'Social page focused on news, achievements and memory fragments from Bazma.',
        7 => 'صفحة اجتماعية حول أخبار ونجاحات وذاكرة بازمة.',
        8 => 'https://www.facebook.com/p/Bazma-%D8%A8%D8%A7%D8%B2%D9%85%D8%A9-%D8%AD%D9%83%D8%A7%D9%8A%D8%A9-%D8%A8%D9%84%D8%AF-bazma-2-100071547231876/',
        9 => '/assets/bazma-memory.webp',
        10 => 'Mémoire',
        11 => true,
        12 => 4,
      ),
      4 => 
      array (
        0 => 37,
        1 => 'Facebook',
        2 => 'Camera Andalib - عشوية الخيل',
        3 => 'Camera Andalib - horse evening',
        4 => 'كاميرا العندليب - عشوية الخيل',
        5 => 'Publication récente avec photos de عشوية الخيل / ثاني العيد à قرية بازمة، قبلي.',
        6 => 'Recent post with photos from the horse evening / Eid event in Bazma village.',
        7 => 'منشور حديث بصور عشوية الخيل / ثاني العيد في قرية بازمة، قبلي.',
        8 => 'https://www.facebook.com/andalibstudio/posts/%D8%A8%D8%B9%D8%B6-%D9%85%D9%86-%D8%A7%D9%84%D8%B5%D9%88%D8%B1-%D9%84%D9%85%D9%88%D8%A7%D9%83%D8%A8%D8%A9-%D9%83%D8%A7%D9%85%D9%8A%D8%B1%D8%A7-%D8%A7%D9%84%D8%B9%D9%86%D8%AF%D9%84%D9%8A%D8%A8-%D9%84%D8%B9%D8%B4',
        9 => '/assets/bazma-horses.webp',
        10 => 'Traditions',
        11 => true,
        12 => 5,
      ),
      5 => 
      array (
        0 => 38,
        1 => 'Facebook',
        2 => 'Commune Kebili - match Bazma',
        3 => 'Kebili commune - Bazma match',
        4 => 'بلدية قبلي - مباراة بازمة',
        5 => 'Publication publique sur une rencontre sportive impliquant Bazma.',
        6 => 'Public post about a sports match involving Bazma.',
        7 => 'منشور عام حول مقابلة رياضية شاركت فيها بازمة.',
        8 => 'https://www.facebook.com/commune.kebili/posts/%D8%B5%D9%88%D8%B1-%D9%85%D9%86-%D9%85%D8%A8%D8%A7%D8%B1%D8%A7%D8%A9-%D8%A8%D8%A7%D8%B2%D9%85%D8%A9-%D9%88-%D8%A7%D9%84%D8%B1%D8%AD%D9%85%D8%A7%D8%AA-%D9%8A%D9%88%D9%85-%D8%A7%D9%85%D8%B3-%D8%A8%D8%A7%D9%84%D9',
        9 => '/assets/bazma-sport.webp',
        10 => 'Sport',
        11 => true,
        12 => 6,
      ),
      6 => 
      array (
        0 => 39,
        1 => 'Facebook',
        2 => 'Jeun’ESS - Maison des jeunes de Bazma',
        3 => 'Jeun’ESS - Bazma youth center',
        4 => 'Jeun’ESS - دار الشباب بازمة',
        5 => 'Vidéo/projet mentionnant la Maison des jeunes de Bazma, Kebili.',
        6 => 'Video/project mentioning the Bazma youth center, Kebili.',
        7 => 'فيديو/مشروع يذكر دار الشباب بازمة، قبلي.',
        8 => 'https://www.facebook.com/jeuness.eu4youth/videos/limitless-generation-a%CC%80-la-maison-des-jeunes-de-bazma-kebili/1015270436479405/',
        9 => '/assets/bazma-youth.webp',
        10 => 'Projet',
        11 => true,
        12 => 7,
      ),
      7 => 
      array (
        0 => 40,
        1 => 'Facebook',
        2 => 'Elite Football - Académie Bazma',
        3 => 'Elite Football - Bazma academy',
        4 => 'Elite Football - أكاديمية بازمة',
        5 => 'Publication sportive récente mentionnant une académie de Bazma.',
        6 => 'Recent sports post mentioning a Bazma academy.',
        7 => 'منشور رياضي حديث يذكر أكاديمية بازمة.',
        8 => 'https://www.facebook.com/Elite.football.academie.kebili/posts/%D9%81%D8%B1%D8%B9-%D8%A7%D9%84%D8%A8%D8%B1%D8%BA%D9%88%D8%AB%D9%8A%D8%A9-%D8%A8%D8%B9%D8%B6-%D8%B5%D9%88%D8%B1-%D8%A7%D9%84%D9%85%D8%A8%D8%A7%D8%B1%D9%8A%D8%A7%D8%AA-%D9%85%D8%B9-%D8%A7%D9%83%',
        9 => '/assets/bazma-sport.webp',
        10 => 'Sport',
        11 => true,
        12 => 8,
      ),
    ),
  ),
);

    private const DELETE_ORDER = [
        'page_media',
        'social_link',
        'community_organization',
        'gallery_image',
        'event',
        'page',
        'site_setting',
        'admin_user',
    ];

    private const BOOLEAN_COLUMNS = [
        'admin_user' => ['active'],
        'community_organization' => ['active'],
        'event' => ['published', 'featured'],
        'gallery_image' => ['featured'],
        'page' => ['published'],
        'social_link' => ['featured'],
    ];

    public function getDescription(): string
    {
        return 'Load the production Bazma content snapshot from bazma.sql';
    }

    public function up(Schema $schema): void
    {
        $this->deleteSnapshotTables();

        foreach (self::DATA as $table => $payload) {
            $this->insertRows($table, $payload['columns'], $payload['rows']);
            $this->resetIdentity($table, $payload['rows']);
        }
    }

    public function down(Schema $schema): void
    {
        $this->deleteSnapshotTables();
    }

    private function deleteSnapshotTables(): void
    {
        foreach (self::DELETE_ORDER as $table) {
            $this->addSql(sprintf('DELETE FROM %s', $this->identifier($table)));
        }
    }

    /**
     * @param list<string> $columns
     * @param list<list<mixed>> $rows
     */
    private function insertRows(string $table, array $columns, array $rows): void
    {
        $quotedColumns = array_map(fn (string $column): string => $this->identifier($column), $columns);
        $placeholders = array_map(fn (string $column): string => ':' . $column, $columns);
        $sql = sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            $this->identifier($table),
            implode(', ', $quotedColumns),
            implode(', ', $placeholders),
        );

        foreach ($rows as $row) {
            $params = array_combine($columns, $row);
            $types = $this->parameterTypes($table, $columns, $params);
            $this->addSql($sql, $params, $types);
        }
    }

    /**
     * @param list<string> $columns
     * @param array<string, mixed> $params
     * @return array<string, ParameterType>
     */
    private function parameterTypes(string $table, array $columns, array $params): array
    {
        $types = [];
        $booleanColumns = self::BOOLEAN_COLUMNS[$table] ?? [];

        foreach ($columns as $column) {
            if ($params[$column] === null) {
                $types[$column] = ParameterType::NULL;
            } elseif (in_array($column, $booleanColumns, true)) {
                $types[$column] = ParameterType::BOOLEAN;
            } elseif ($column === 'id' || $column === 'position') {
                $types[$column] = ParameterType::INTEGER;
            } else {
                $types[$column] = ParameterType::STRING;
            }
        }

        return $types;
    }

    /**
     * @param list<list<mixed>> $rows
     */
    private function resetIdentity(string $table, array $rows): void
    {
        if ($rows === []) {
            return;
        }

        $maxId = max(array_map(static fn (array $row): int => (int) $row[0], $rows));

        if ($this->isPostgreSql()) {
            $this->addSql(sprintf(
                "SELECT setval(pg_get_serial_sequence('%s', 'id'), %d, true)",
                str_replace("'", "''", $table),
                $maxId,
            ));

            return;
        }

        if ($this->isMySql()) {
            $this->addSql(sprintf('ALTER TABLE %s AUTO_INCREMENT = %d', $this->identifier($table), $maxId + 1));
        }
    }

    private function identifier(string $name): string
    {
        return $this->isPostgreSql()
            ? '"' . str_replace('"', '""', $name) . '"'
            : '`' . str_replace('`', '``', $name) . '`';
    }

    private function isPostgreSql(): bool
    {
        return str_contains($this->connection->getDatabasePlatform()::class, 'PostgreSQL');
    }

    private function isMySql(): bool
    {
        return str_contains($this->connection->getDatabasePlatform()::class, 'MySQL')
            || str_contains($this->connection->getDatabasePlatform()::class, 'MariaDB');
    }
}
