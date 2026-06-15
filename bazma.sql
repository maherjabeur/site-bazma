-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 13 juin 2026 à 18:30
-- Version du serveur : 8.4.7
-- Version de PHP : 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bazma`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin_user`
--

DROP TABLE IF EXISTS `admin_user`;
CREATE TABLE IF NOT EXISTS `admin_user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `admin_user`
--

INSERT INTO `admin_user` (`id`, `email`, `name`, `roles`, `password`, `active`) VALUES
(1, 'maherjabeur@gmail.com', 'Administrateur', '[\"ROLE_SUPER_ADMIN\"]', '$2y$13$odBv6jR00kGjXZP76E.rJ./AgWRHr620GQgViJdTkNgWt906GX9vO', 1);

-- --------------------------------------------------------

--
-- Structure de la table `community_organization`
--

DROP TABLE IF EXISTS `community_organization`;
CREATE TABLE IF NOT EXISTS `community_organization` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(160) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(160) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_ar` varchar(160) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_en` longtext COLLATE utf8mb4_unicode_ci,
  `description_ar` longtext COLLATE utf8mb4_unicode_ci,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  `position` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `community_organization`
--

INSERT INTO `community_organization` (`id`, `name`, `name_en`, `name_ar`, `type`, `description`, `description_en`, `description_ar`, `url`, `image_url`, `active`, `position`) VALUES
(5, 'Association Bazma culture, tourisme et loisirs', 'Bazma Association for Culture, Tourism and Leisure', 'جمعية بازمة للثقافة والسياحة والترفيه', 'Association culturelle', 'Association locale repérée dans une publication publique officielle. Elle donne au site une base sérieuse pour démarrer un annuaire des structures de Bazma, à compléter avec les responsables locaux.', 'Local association identified in an official public publication. It gives the website a solid starting point for a Bazma local directory, to be completed with local representatives.', 'جمعية محلية مذكورة في منشور عمومي رسمي. تمثل نقطة انطلاق جدية لبناء دليل هياكل بازمة مع استكمال المعطيات من المسؤولين المحليين.', 'https://pm.gov.tn/sites/default/files/2024-11/%D8%A8%D9%84%D8%A7%D8%BA%20%D8%AD%D9%88%D9%84%20%20%D8%A7%D9%84%D8%AA%D9%85%D9%88%D9%8A%D9%84%20%20%20%D8%A7%D9%84%D8%A3%D8%AC%D9%86%D8%A8%D9%8A%20.pdf', '/assets/bazma-memory.webp', 1, 1),
(6, 'Association sportive Bazma', 'Bazma Sports Association', 'جمعية بازمة الرياضية', 'Sport', 'Trace sportive publique liée à Bazma, utile pour structurer les archives des équipes, matchs, photos, résultats et parcours des jeunes sportifs du village.', 'Public sports trace linked to Bazma, useful for organizing archives of teams, matches, photos, results and youth sports journeys.', 'أثر رياضي عمومي مرتبط ببازمة، مفيد لتنظيم أرشيف الفرق والمباريات والصور والنتائج ومسارات الشباب الرياضي.', 'https://www.ftf.org.tn/ar2/category/%D8%B1%D9%91%D8%A7%D8%A8%D8%B7%D8%A9-%D9%82%D8%A7%D8%A8%D8%B3/', '/assets/bazma-sport.webp', 1, 2),
(7, 'Maison des jeunes de Bazma', 'Bazma Youth Center', 'دار الشباب بازمة', 'Structure jeunesse', 'Structure jeunesse centrale pour Bazma: activités, annonces, formations, rencontres et contenus à valider avec les responsables avant publication sur le site.', 'A central youth structure for Bazma: activities, announcements, trainings, meetings and content to validate with the people in charge before publishing.', 'هيكل شبابي أساسي في بازمة: أنشطة وإعلانات وتكوينات ولقاءات ومحتوى يجب التثبت منه مع المسؤولين قبل النشر.', 'https://www.facebook.com/p/%D8%AF%D8%A7%D8%B1-%D8%A7%D9%84%D8%B4%D8%A8%D8%A7%D8%A8-%D8%A8%D8%A7%D8%B2%D9%85%D8%A9-100089146635794/', '/assets/bazma-youth.webp', 1, 3),
(8, 'Initiatives jeunesse à Bazma', 'Youth initiatives in Bazma', 'مبادرات شبابية في بازمة', 'Projet jeunesse', 'Des initiatives publiques mentionnent la Maison des jeunes de Bazma. Le CMS peut centraliser ces actions avec leurs dates, photos autorisées et liens sources.', 'Public initiatives mention the Bazma youth center. The CMS can centralize these actions with dates, authorized photos and source links.', 'تذكر مبادرات عمومية دار الشباب بازمة. يمكن لنظام الإدارة تجميع هذه الأنشطة مع التواريخ والصور المرخصة وروابط المصادر.', 'https://www.facebook.com/jeuness.eu4youth/videos/limitless-generation-a%CC%80-la-maison-des-jeunes-de-bazma-kebili/1015270436479405/', '/assets/bazma-youth.webp', 1, 4);

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20260612123000', '2026-06-12 11:46:29', 348),
('DoctrineMigrations\\Version20260612133000', '2026-06-12 12:10:59', 70),
('DoctrineMigrations\\Version20260612143000', '2026-06-12 12:37:16', 40),
('DoctrineMigrations\\Version20260612152000', '2026-06-12 13:19:59', 64),
('DoctrineMigrations\\Version20260612170000', '2026-06-12 16:35:30', 154),
('DoctrineMigrations\\Version20260612171000', '2026-06-12 16:37:51', 33),
('DoctrineMigrations\\Version20260612180000', '2026-06-12 20:25:24', 340),
('DoctrineMigrations\\Version20260612183000', '2026-06-12 20:44:22', 11),
('DoctrineMigrations\\Version20260613120000', '2026-06-13 10:50:15', 119);

-- --------------------------------------------------------

--
-- Structure de la table `event`
--

DROP TABLE IF EXISTS `event`;
CREATE TABLE IF NOT EXISTS `event` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(160) COLLATE utf8mb4_unicode_ci NOT NULL,
  `event_date` date DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `published` tinyint(1) NOT NULL,
  `title_en` varchar(160) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_ar` varchar(160) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_en` longtext COLLATE utf8mb4_unicode_ci,
  `description_ar` longtext COLLATE utf8mb4_unicode_ci,
  `category` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Actualite',
  `source_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT '1',
  `position` int NOT NULL DEFAULT '0',
  `slug` varchar(170) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `excerpt` varchar(220) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `excerpt_en` varchar(220) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `excerpt_ar` varchar(220) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_3BAE0AA989D9B62` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `event`
--

INSERT INTO `event` (`id`, `title`, `event_date`, `location`, `description`, `published`, `title_en`, `title_ar`, `description_en`, `description_ar`, `category`, `source_url`, `featured`, `position`, `slug`, `image_url`, `excerpt`, `excerpt_en`, `excerpt_ar`) VALUES
(22, 'Collecte officielle des photos de Bazma', NULL, 'Bazma', 'Contacter les pages Facebook locales et les familles pour récupérer des images autorisées du village.', 1, 'Official Bazma photo collection', 'جمع رسمي لصور بازمة', 'Contact local Facebook pages and families to collect authorized images of the village.', 'التواصل مع صفحات فيسبوك المحلية والعائلات لجمع صور مرخصة للقرية.', 'Photos', 'https://www.facebook.com/AirportBazma/photos/', 0, 22, 'actualite-22-collecte-officielle-des-photos-de-bazma', NULL, NULL, NULL, NULL),
(23, 'Archive Maison des jeunes Bazma', NULL, 'Bazma', 'Créer une archive des activités, annonces, formations et photos validées par دار الشباب بازمة.', 1, 'Bazma youth center archive', 'أرشيف دار الشباب بازمة', 'Create an archive of activities, announcements, trainings and photos approved by دار الشباب بازمة.', 'إنشاء أرشيف للأنشطة والإعلانات والتكوينات والصور المصادق عليها من دار الشباب بازمة.', 'Jeunesse', 'https://www.facebook.com/p/%D8%AF%D8%A7%D8%B1-%D8%A7%D9%84%D8%B4%D8%A8%D8%A7%D8%A8-%D8%A8%D8%A7%D8%B2%D9%85%D8%A9-100089146635794/', 0, 23, 'actualite-23-archive-maison-des-jeunes-bazma', NULL, NULL, NULL, NULL),
(24, 'Mémoire sportive de Bazma', NULL, 'Bazma', 'Rassembler photos, noms d’équipes, résultats et publications sportives liées à Bazma.', 1, 'Bazma sports memory', 'الذاكرة الرياضية لبازمة', 'Gather photos, team names, results and sports posts linked to Bazma.', 'جمع الصور وأسماء الفرق والنتائج والمنشورات الرياضية المرتبطة ببازمة.', 'Sport', 'https://www.ftf.org.tn/ar2/category/%D8%B1%D9%91%D8%A7%D8%A8%D8%B7%D8%A9-%D9%82%D8%A7%D8%A8%D8%B3/', 0, 24, 'actualite-24-mémoire-sportive-de-bazma', NULL, NULL, NULL, NULL),
(25, 'Dossier associations de Bazma', '2026-06-12', 'Bazma', 'Première base CMS pour les associations et structures repérées à Bazma, avec liens sources et vérification locale à compléter.', 1, 'Bazma associations file', 'ملف جمعيات بازمة', 'First CMS base for associations and structures identified in Bazma, with source links and local verification to complete.', 'قاعدة أولية داخل نظام الإدارة للجمعيات والهياكل التي تم رصدها في بازمة، مع روابط المصادر واستكمال التثبت محليا.', 'Associations', 'https://pm.gov.tn/sites/default/files/2024-11/%D8%A8%D9%84%D8%A7%D8%BA%20%D8%AD%D9%88%D9%84%20%20%D8%A7%D9%84%D8%AA%D9%85%D9%88%D9%8A%D9%84%20%20%20%D8%A7%D9%84%D8%A3%D8%AC%D9%86%D8%A8%D9%8A%20.pdf', 0, 21, 'actualite-25-dossier-associations-de-bazma', NULL, NULL, NULL, NULL),
(26, 'Collecte officielle des photos de Bazma', '2026-06-12', 'Bazma', 'Le site Bazma ouvre une collecte éditoriale dédiée aux images du village. L\'objectif est de publier uniquement des photos autorisées, correctement créditées et utiles à la mémoire locale.\n\nChaque contribution pourra être ajoutée depuis le CMS avec son titre, sa légende, son auteur, son lien source et son contexte.', 1, 'Official Bazma photo collection', 'جمع رسمي لصور بازمة', 'The Bazma website is opening an editorial collection dedicated to village images. The goal is to publish only authorized photos, properly credited and useful to local memory.\n\nEach contribution can be added through the CMS with its title, caption, author, source link and context.', 'يفتح موقع بازمة جمعا تحريريا مخصصا لصور القرية. الهدف هو نشر صور مرخصة فقط، مع ذكر صاحب الصورة والسياق والمصدر.\n\nيمكن إضافة كل مساهمة من نظام الإدارة مع العنوان والتعليق والرابط والمعلومات المحلية.', 'Mémoire', NULL, 1, 1, 'actualite-photos-bazma', '/assets/bazma-memory.webp', 'Un appel à contribution pour réunir des photos autorisées du village, avec crédit, date, lieu et lien source.', 'A contribution call to gather authorized village photos with credit, date, place and source link.', 'دعوة لجمع صور مرخصة للقرية مع الاعتماد والتاريخ والمكان ورابط المصدر.'),
(27, 'La Maison des jeunes au coeur de l’archive locale', '2026-06-10', 'Maison des jeunes de Bazma', 'Le CMS permet de transformer les activités locales en actualités lisibles: image de couverture, résumé court, contenu complet, date, catégorie et lien source.\n\nCette structure aide à suivre les projets jeunesse et à garder une trace claire des moments importants pour Bazma.', 1, 'The youth center at the heart of the local archive', 'دار الشباب في قلب الأرشيف المحلي', 'The CMS turns local activities into readable news: cover image, short summary, full story, date, category and source link.\n\nThis structure helps follow youth projects and keep a clear record of important moments for Bazma.', 'يسمح نظام الإدارة بتحويل الأنشطة المحلية إلى أخبار واضحة: صورة رئيسية، ملخص قصير، نص كامل، تاريخ، صنف ورابط مصدر.\n\nيساعد ذلك على متابعة مشاريع الشباب وحفظ لحظات مهمة لبازمة.', 'Jeunesse', NULL, 1, 2, 'actualite-maison-jeunes-bazma', '/assets/bazma-youth.webp', 'Activités, annonces, formations et événements jeunesse peuvent maintenant être structurés comme de vraies actualités.', 'Activities, announcements, trainings and youth events can now be structured as real news stories.', 'يمكن الآن تنظيم الأنشطة والإعلانات والتكوينات وتظاهرات الشباب كأخبار حقيقية.'),
(28, 'Sport à Bazma: matchs, équipes et mémoire collective', '2026-06-08', 'Bazma', 'Les actualités sportives peuvent devenir une archive vivante: chaque match, tournoi, académie ou réussite locale peut être publié avec une image, une source et une date.\n\nLe but est de construire une mémoire sportive locale propre, consultable et facile à enrichir.', 1, 'Sport in Bazma: matches, teams and shared memory', 'الرياضة في بازمة: مباريات وفرق وذاكرة مشتركة', 'Sports news can become a living archive: every match, tournament, academy moment or local success can be published with an image, source and date.\n\nThe goal is to build a clean local sports memory that is easy to browse and enrich.', 'يمكن أن تصبح الأخبار الرياضية أرشيفا حيا: كل مقابلة أو دورة أو نجاح محلي يمكن نشره بصورة ومصدر وتاريخ.\n\nالهدف هو بناء ذاكرة رياضية محلية واضحة وسهلة الإثراء.', 'Sport', NULL, 1, 3, 'actualite-sport-bazma', '/assets/bazma-sport.webp', 'Une rubrique pour documenter les équipes, les résultats, les photos de matchs et les parcours des jeunes sportifs.', 'A section to document teams, results, match photos and youth sports journeys.', 'قسم لتوثيق الفرق والنتائج وصور المباريات ومسارات الشباب الرياضي.'),
(29, 'Un annuaire vivant pour les associations de Bazma', '2026-06-06', 'Bazma', 'Les associations et structures locales disposent maintenant d’un espace clair dans le CMS. Une fiche peut contenir un type, une description multilingue, une image et un lien source.\n\nLes actualités permettent ensuite de raconter les actions importantes menées autour de Bazma.', 1, 'A living directory for Bazma associations', 'دليل حي لجمعيات بازمة', 'Local associations and structures now have a clear space in the CMS. A profile can include a type, multilingual description, image and source link.\n\nNews stories can then highlight important actions around Bazma.', 'أصبحت للجمعيات والهياكل المحلية مساحة واضحة في نظام الإدارة. يمكن أن تحتوي البطاقة على النوع والوصف متعدد اللغات والصورة ورابط المصدر.\n\nثم تسمح الأخبار بعرض الأعمال المهمة حول بازمة.', 'Associations', NULL, 1, 4, 'actualite-associations-bazma', '/assets/bazma-airport.webp', 'Le site peut présenter les structures locales avec description, photo, lien source et statut de visibilité.', 'The site can present local structures with description, photo, source link and visibility status.', 'يمكن للموقع عرض الهياكل المحلية مع الوصف والصورة ورابط المصدر وحالة الظهور.');

-- --------------------------------------------------------

--
-- Structure de la table `gallery_image`
--

DROP TABLE IF EXISTS `gallery_image`;
CREATE TABLE IF NOT EXISTS `gallery_image` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(160) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `credit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `source_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `featured` tinyint(1) NOT NULL,
  `position` int NOT NULL,
  `title_en` varchar(160) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_ar` varchar(160) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `gallery_image`
--

INSERT INTO `gallery_image` (`id`, `title`, `image_url`, `credit`, `source_url`, `featured`, `position`, `title_en`, `title_ar`) VALUES
(47, 'Bazma - oasis et terre', '/assets/bazma-oasis.webp', 'Visuel local provisoire - remplacer par une photo autorisée de Bazma', 'https://www.facebook.com/AirportBazma/photos/', 1, 1, 'Bazma - oasis and land', 'بازمة - الواحة والأرض'),
(48, 'Bazma - jeunesse', '/assets/bazma-youth.webp', 'Référence: دار الشباب بازمة - demander autorisation pour photos', 'https://www.facebook.com/p/%D8%AF%D8%A7%D8%B1-%D8%A7%D9%84%D8%B4%D8%A8%D8%A7%D8%A8-%D8%A8%D8%A7%D8%B2%D9%85%D8%A9-100089146635794/', 1, 2, 'Bazma - youth', 'بازمة - الشباب'),
(49, 'Bazma - traditions et chevaux', '/assets/bazma-horses.webp', 'Référence: Camera Andalib - photos à autoriser', 'https://www.facebook.com/andalibstudio/posts/%D8%A8%D8%B9%D8%B6-%D9%85%D9%86-%D8%A7%D9%84%D8%B5%D9%88%D8%B1-%D9%84%D9%85%D9%88%D8%A7%D9%83%D8%A8%D8%A9-%D9%83%D8%A7%D9%85%D9%8A%D8%B1%D8%A7-%D8%A7%D9%84%D8%B9%D9%86%D8%AF%D9%84%D9%8A%D8%A8-%D9%84%D8%B9%D8%B4', 1, 3, 'Bazma - traditions and horses', 'بازمة - التقاليد والخيول'),
(50, 'Bazma - sport', '/assets/bazma-sport.webp', 'Référence: publications sportives publiques autour de Bazma', 'https://www.facebook.com/commune.kebili/posts/%D8%B5%D9%88%D8%B1-%D9%85%D9%86-%D9%85%D8%A8%D8%A7%D8%B1%D8%A7%D8%A9-%D8%A8%D8%A7%D8%B2%D9%85%D8%A9-%D9%88-%D8%A7%D9%84%D8%B1%D8%AD%D9%85%D8%A7%D8%AA-%D9%8A%D9%88%D9%85-%D8%A7%D9%85%D8%B3-%D8%A8%D8%A7%D9%84%D9', 1, 4, 'Bazma - sport', 'بازمة - الرياضة'),
(51, 'Bazma - mémoire', '/assets/bazma-memory.webp', 'Référence: Bazma بازمة حكاية بلد bazma 2', 'https://www.facebook.com/p/Bazma-%D8%A8%D8%A7%D8%B2%D9%85%D8%A9-%D8%AD%D9%83%D8%A7%D9%8A%D8%A9-%D8%A8%D9%84%D8%AF-bazma-2-100071547231876/', 1, 5, 'Bazma - memory', 'بازمة - الذاكرة'),
(52, 'Bazma - espace public', '/assets/bazma-airport.webp', 'Référence: Airport kebili-Bazma', 'https://www.facebook.com/AirportBazma/', 1, 6, 'Bazma - public space', 'بازمة - الفضاء العام');

-- --------------------------------------------------------

--
-- Structure de la table `page`
--

DROP TABLE IF EXISTS `page`;
CREATE TABLE IF NOT EXISTS `page` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(140) COLLATE utf8mb4_unicode_ci NOT NULL,
  `summary` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `published` tinyint(1) NOT NULL,
  `position` int NOT NULL,
  `title_en` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_ar` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `summary_en` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `summary_ar` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body_en` longtext COLLATE utf8mb4_unicode_ci,
  `body_ar` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_140AB620989D9B62` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `page`
--

INSERT INTO `page` (`id`, `title`, `slug`, `summary`, `body`, `image_url`, `published`, `position`, `title_en`, `title_ar`, `summary_en`, `summary_ar`, `body_en`, `body_ar`) VALUES
(39, 'Bazma en bref', 'bazma-en-bref', 'Bazma est un village oasien de la délégation de Kébili Sud, avec une identité locale forte.', '<p>Bazma est située près de Kébili, dans le Sud tunisien. Les sources géographiques publiques la placent autour de 33.66583 N et 9.01167 E. Ce site doit rester centré sur Bazma seulement: ses habitants, ses lieux, son oasis, sa jeunesse, ses photos et ses archives.</p><figure class=\"\" data-size=\"50\" data-align=\"wrap-left\"><img src=\"/assets/bazma-airport.webp\" alt=\"Bazma - espace public - Référence: Airport kebili-Bazma\"><figcaption>Bazma - espace public - Référence: Airport kebili-Bazma</figcaption></figure><p><br></p><p>Le contenu initial combine des sources publiques classiques et des traces sociales visibles sur Facebook. Les photos exactes de Bazma repérées sur les réseaux ne sont pas copiées sans autorisation: elles sont référencées pour contacter les auteurs, demander l\'accord, puis ajouter les images avec crédit dans le CMS.</p><p><br></p><figure data-size=\"100\" data-align=\"center\"><video controls=\"\" playsinline=\"\" preload=\"metadata\" src=\"/uploads/videos/editeur-15046073-3240-2160-60fps-8e93255d9a.mp4\"></video><figcaption>Video</figcaption></figure><p><br></p><p><br></p>', '/assets/bazma-oasis.webp', 1, 1, 'Bazma at a glance', 'بازمة في لمحة', 'Bazma is an oasis village in the Kebili South delegation, with a strong local identity.', 'بازمة قرية واحية من معتمدية قبلي الجنوبية، ولها هوية محلية واضحة.', '<p>Bazma is located near Kebili in southern Tunisia. Public geographic sources place it around 33.66583 N and 9.01167 E. This website must stay focused only on Bazma: its people, places, oasis, youth, photos and archives.</p><p>The starter content combines public reference sources and social traces visible on Facebook. Exact Bazma photos found on social media are not copied without permission: they are referenced so authors can be contacted, permission requested and credited photos added through the CMS.</p>', '<p>تقع بازمة قرب قبلي في الجنوب التونسي. وتضعها المصادر الجغرافية العامة حول الإحداثيات 33.66583 شمالا و9.01167 شرقا. يجب أن يبقى هذا الموقع مخصصا لبازمة فقط: أهلها، أماكنها، واحتها، شبابها، صورها وأرشيفها.</p><p>يمزج المحتوى الأولي بين مصادر عامة وآثار اجتماعية منشورة على فيسبوك. لا يتم نسخ صور بازمة الدقيقة من الشبكات دون إذن، بل توضع الروابط للتواصل مع أصحابها وطلب الموافقة ثم إضافة الصور مع الاعتماد داخل نظام الإدارة.</p>'),
(40, 'Oasis, eau et terre', 'oasis-eau-terre', 'La mémoire de Bazma passe par son oasis, l’eau, les cultures et le travail de la terre.', 'Le document FIES du ministère tunisien de l\'environnement mentionne l\'oasis de Bazma dans le cadre d\'un projet de réhabilitation du périmètre irrigué. La page arabe de Bazma signale aussi la réputation du village autour de la terre et des cultures maraîchères.\n\nCette page doit devenir un espace local: noms des parcelles, puits, souvenirs de récoltes, techniques d\'irrigation, anciennes photos d\'oasis et témoignages d\'agriculteurs.', '/assets/bazma-oasis.webp', 1, 2, 'Oasis, water and land', 'الواحة والماء والأرض', 'Bazma’s memory runs through its oasis, water, crops and work on the land.', 'تمر ذاكرة بازمة عبر الواحة والماء والزراعات وخدمة الأرض.', 'The FIES document from the Tunisian Ministry of Environment mentions the Bazma oasis as part of an irrigated perimeter rehabilitation project. The Arabic page about Bazma also points to the village’s reputation for working the land and growing vegetables.\n\nThis page should become a local space: plot names, wells, harvest memories, irrigation practices, old oasis photos and farmers’ testimonies.', 'تذكر وثيقة FIES لوزارة البيئة التونسية واحة بازمة ضمن مشروع إعادة تأهيل محيط سقوي. كما تشير الصفحة العربية الخاصة ببازمة إلى شهرة القرية بخدمة الأرض وغراسة الخضر.\n\nيمكن أن تصبح هذه الصفحة فضاء محليا لأسماء القطع والآبار وذكريات الجني وتقنيات الري والصور القديمة للواحة وشهادات الفلاحين.'),
(41, 'Jeunesse et Maison des jeunes', 'jeunesse-maison-des-jeunes', 'Les publications de دار الشباب بازمة montrent une activité locale importante autour des jeunes.', 'La page Facebook دار الشباب بازمة publie des annonces, activités, rencontres et contenus liés aux jeunes de Bazma. Des sources comme Jeun\'ESS / EU4Youth mentionnent aussi des initiatives à la Maison des jeunes de Bazma.\n\nLe site doit référencer ces actions: orientation des élèves, activités culturelles, projets citoyens, formations, événements et photos validées par les responsables.', '/assets/bazma-youth.webp', 1, 3, 'Youth and youth center', 'الشباب ودار الشباب', 'Posts from دار الشباب بازمة show important local activity around young people.', 'تظهر منشورات دار الشباب بازمة نشاطا محليا مهما موجها للشباب.', 'The دار الشباب بازمة Facebook page publishes announcements, activities, meetings and content linked to Bazma’s youth. Sources such as Jeun\'ESS / EU4Youth also mention initiatives at the Bazma youth center.\n\nThe website should reference these actions: student guidance, cultural activities, civic projects, trainings, events and photos approved by the people in charge.', 'تنشر صفحة دار الشباب بازمة على فيسبوك إعلانات وأنشطة ولقاءات ومحتويات مرتبطة بشباب بازمة. كما تذكر مصادر مثل Jeun\'ESS / EU4Youth مبادرات في دار الشباب بازمة.\n\nينبغي أن يوثق الموقع هذه الأنشطة: توجيه التلاميذ، الأنشطة الثقافية، المشاريع المواطنة، التكوينات، التظاهرات والصور المصادق عليها من المسؤولين.'),
(42, 'Fêtes, chevaux et vie sociale', 'fetes-chevaux-vie-sociale', 'Des publications Facebook récentes documentent des moments de fête et de vie sociale à Bazma.', 'Camera Andalib a publié des contenus autour de عشوية الخيل / ثاني العيد à قرية بازمة، قبلي. Ces contenus sont précieux pour raconter la vie sociale, les fêtes, les chevaux et les rassemblements.\n\nLes images ne sont pas intégrées directement sans accord. La bonne procédure: contacter le studio ou l\'auteur, récupérer l\'image autorisée, indiquer le crédit, puis l\'ajouter dans la galerie du CMS.', '/assets/bazma-horses.webp', 1, 4, 'Celebrations, horses and social life', 'المناسبات والخيول والحياة الاجتماعية', 'Recent Facebook posts document celebrations and social life moments in Bazma.', 'توثق منشورات فيسبوك حديثة مناسبات ولحظات اجتماعية في بازمة.', 'Camera Andalib published content around عشوية الخيل / ثاني العيد in قرية بازمة، قبلي. These posts are valuable for telling the story of social life, celebrations, horses and gatherings.\n\nImages are not embedded directly without permission. The right process is to contact the studio or author, obtain the authorized image, add the credit and then upload it to the CMS gallery.', 'نشرت كاميرا العندليب محتوى حول عشوية الخيل / ثاني العيد في قرية بازمة، قبلي. هذه المنشورات مهمة لتوثيق الحياة الاجتماعية والمناسبات والخيول والتجمعات.\n\nلا تدرج الصور مباشرة دون إذن. الطريقة الصحيحة هي التواصل مع الاستوديو أو صاحب الصورة، الحصول على صورة مرخصة، ذكر الاعتماد ثم إضافتها إلى معرض نظام الإدارة.'),
(43, 'Sport et équipes de Bazma', 'sport-equipes-bazma', 'Facebook garde des traces de matchs, d’académies et de jeunes sportifs liés à Bazma.', 'Des résultats de recherche montrent des publications sur des matchs impliquant Bazma, notamment une publication ancienne de la Commune de Kébili et des contenus récents autour d\'une académie de Bazma.\n\nCette page peut devenir l\'archive sportive du village: équipes, photos de matchs, noms des joueurs, résultats, tournois locaux, médailles et parcours des jeunes.', '/assets/bazma-sport.webp', 1, 5, 'Sport and Bazma teams', 'الرياضة وفرق بازمة', 'Facebook keeps traces of matches, academies and young athletes linked to Bazma.', 'يحفظ فيسبوك آثار مباريات وأكاديميات وشباب رياضيين مرتبطين ببازمة.', 'Search results show posts about matches involving Bazma, including an older post from the Commune of Kebili and recent content around a Bazma academy.\n\nThis page can become the village sports archive: teams, match photos, player names, results, local tournaments, medals and youth journeys.', 'تظهر نتائج البحث منشورات حول مباريات شاركت فيها بازمة، منها منشور قديم لبلدية قبلي ومحتويات حديثة حول أكاديمية بازمة.\n\nيمكن أن تصبح هذه الصفحة أرشيفا رياضيا للقرية: الفرق، صور المباريات، أسماء اللاعبين، النتائج، الدورات المحلية، الميداليات ومسارات الشباب.'),
(44, 'Photos de Bazma: méthode de collecte', 'photos-bazma-collecte', 'Les vraies images de Bazma doivent venir des habitants, pages locales et publications Facebook autorisées.', 'Sources prioritaires à contacter: Airport kebili-Bazma, دار الشباب بازمة, Bazma بازمة حكاية بلد bazma 2, Camera Andalib, pages sportives et publications publiques qui mentionnent قرية بازمة.\n\nAvant publication: demander l\'accord, noter l\'auteur, la date, le lieu, la légende, le lien source et le niveau d\'autorisation. Ensuite, ajouter l\'image au CMS avec son crédit. Cette règle protège le site et respecte les habitants.', '/assets/bazma-memory.webp', 1, 6, 'Bazma photos: collection method', 'صور بازمة: طريقة الجمع', 'Real Bazma images should come from residents, local pages and authorized Facebook posts.', 'يجب أن تأتي صور بازمة الحقيقية من السكان والصفحات المحلية ومنشورات فيسبوك المرخصة.', 'Priority sources to contact: Airport kebili-Bazma, دار الشباب بازمة, Bazma بازمة حكاية بلد bazma 2, Camera Andalib, sports pages and public posts mentioning قرية بازمة.\n\nBefore publication: ask permission, record author, date, place, caption, source link and permission level. Then add the image to the CMS with its credit. This rule protects the website and respects residents.', 'مصادر ذات أولوية للتواصل: Airport kebili-Bazma، دار الشباب بازمة، Bazma بازمة حكاية بلد bazma 2، كاميرا العندليب، الصفحات الرياضية والمنشورات العامة التي تذكر قرية بازمة.\n\nقبل النشر: طلب الإذن، تسجيل اسم صاحب الصورة، التاريخ، المكان، التعليق، رابط المصدر ومستوى الترخيص. بعد ذلك تضاف الصورة إلى نظام الإدارة مع الاعتماد. هذه القاعدة تحمي الموقع وتحترم أهل القرية.');

-- --------------------------------------------------------

--
-- Structure de la table `page_media`
--

DROP TABLE IF EXISTS `page_media`;
CREATE TABLE IF NOT EXISTS `page_media` (
  `id` int NOT NULL AUTO_INCREMENT,
  `page_id` int NOT NULL,
  `title` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `caption` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E0F3026EC4663E4` (`page_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `site_setting`
--

DROP TABLE IF EXISTS `site_setting`;
CREATE TABLE IF NOT EXISTS `site_setting` (
  `id` int NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `setting_value` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_57B40A2045D6295E` (`setting_key`)
) ENGINE=InnoDB AUTO_INCREMENT=194 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `site_setting`
--

INSERT INTO `site_setting` (`id`, `setting_key`, `setting_value`) VALUES
(62, 'site_title', 'Bazma, mémoire vivante du village'),
(63, 'site_title_en', 'Bazma, a living village memory'),
(64, 'site_title_ar', 'بازمة، ذاكرة قرية حيّة'),
(65, 'site_intro', 'Une vitrine dédiée uniquement à Bazma: oasis, familles, jeunesse, photos publiques, sports, fêtes et projets locaux.'),
(66, 'site_intro_en', 'A showcase dedicated only to Bazma: oasis, families, youth, public photos, sports, celebrations and local projects.'),
(67, 'site_intro_ar', 'واجهة مخصصة لبازمة فقط: الواحة، العائلات، الشباب، الصور المنشورة، الرياضة، المناسبات والمشاريع المحلية.'),
(68, 'seo_title_ar', 'بازمة قبلي | ذاكرة القرية والصور والشبكات المحلية'),
(69, 'seo_title_fr', 'Bazma Kebili | Mémoire, photos et réseaux du village'),
(70, 'seo_title_en', 'Bazma Kebili | Village memory, photos and local networks'),
(71, 'seo_description_ar', 'موقع بازمة قبلي لجمع ذاكرة القرية: الواحة، الأهالي، الصور المرخصة، دار الشباب، الرياضة، التقاليد وروابط فيسبوك المحلية.'),
(72, 'seo_description_fr', 'Site Bazma Kebili pour collecter la mémoire du village: oasis, habitants, photos autorisées, Maison des jeunes, sport, traditions et liens Facebook locaux.'),
(73, 'seo_description_en', 'Bazma Kebili website collecting village memory: oasis, people, authorized photos, youth center, sport, traditions and local Facebook links.'),
(74, 'og_image', '/assets/bazma-hero.webp'),
(75, 'footer_text_ar', 'ذاكرة حيّة لبازمة تُبنى مع الأهالي والمصادر المحلية المرخّصة.'),
(76, 'footer_text_fr', 'Mémoire vivante de Bazma, construite avec les habitants et les sources locales autorisées.'),
(77, 'footer_text_en', 'A living memory of Bazma, built with residents and authorized local sources.'),
(78, 'hero_image', '/uploads/accueil-465681125-8865001523521068-7722625421484976979-n-1bf1152aad.webp'),
(80, 'hero_eyebrow_fr', 'Village de Kebili'),
(81, 'hero_eyebrow_en', 'Kebili village'),
(82, 'hero_eyebrow_ar', 'قرية من قبلي'),
(83, 'hero_title_fr', 'Bazma, mémoire vivante du village'),
(84, 'hero_title_en', 'Bazma, a living village memory'),
(85, 'hero_title_ar', 'بازمة، ذاكرة قرية حيّة'),
(86, 'hero_intro_fr', 'Une vitrine dédiée à Bazma: oasis, familles, jeunesse, photos publiques, sport, fêtes et projets locaux.'),
(87, 'hero_intro_en', 'A showcase dedicated to Bazma: oasis, families, youth, public photos, sport, celebrations and local projects.'),
(88, 'hero_intro_ar', 'واجهة مخصصة لبازمة: الواحة، العائلات، الشباب، الصور، الرياضة، المناسبات والمشاريع المحلية.'),
(89, 'hero_primary_label_fr', 'Découvrir'),
(90, 'hero_primary_label_en', 'Explore'),
(91, 'hero_primary_label_ar', 'اكتشف'),
(92, 'hero_primary_url', '#decouvrir'),
(93, 'hero_secondary_label_fr', 'Voir les images'),
(94, 'hero_secondary_label_en', 'View images'),
(95, 'hero_secondary_label_ar', 'شاهد الصور'),
(96, 'hero_secondary_url', '/fr/gallery'),
(97, 'home_fact_1_value', '33.66583, 9.01167'),
(98, 'home_fact_1_label_fr', 'Coordonnées'),
(99, 'home_fact_1_label_en', 'Coordinates'),
(100, 'home_fact_1_label_ar', 'الإحداثيات'),
(101, 'home_fact_2_value', '6-9 km'),
(102, 'home_fact_2_label_fr', 'De Kebili'),
(103, 'home_fact_2_label_en', 'From Kebili'),
(104, 'home_fact_2_label_ar', 'من قبلي'),
(105, 'home_fact_3_value', 'Oasis'),
(106, 'home_fact_3_label_fr', 'Paysage local'),
(107, 'home_fact_3_label_en', 'Local landscape'),
(108, 'home_fact_3_label_ar', 'المشهد المحلي'),
(109, 'home_fact_4_value', 'BWh'),
(110, 'home_fact_4_label_fr', 'Climat aride'),
(111, 'home_fact_4_label_en', 'Arid climate'),
(112, 'home_fact_4_label_ar', 'مناخ جاف'),
(113, 'brand_fr', 'Bazma Kebili'),
(114, 'brand_en', 'Bazma Kebili'),
(115, 'brand_ar', 'بازمة قبلي'),
(116, 'nav_home_fr', 'Accueil'),
(117, 'nav_home_en', 'Home'),
(118, 'nav_home_ar', 'الرئيسية'),
(119, 'nav_discover_fr', 'Découvrir'),
(120, 'nav_discover_en', 'Discover'),
(121, 'nav_discover_ar', 'اكتشف'),
(122, 'nav_gallery_fr', 'Galerie'),
(123, 'nav_gallery_en', 'Gallery'),
(124, 'nav_gallery_ar', 'الصور'),
(125, 'nav_associations_fr', 'Associations'),
(126, 'nav_associations_en', 'Associations'),
(127, 'nav_associations_ar', 'الجمعيات'),
(128, 'nav_social_fr', 'Réseaux'),
(129, 'nav_social_en', 'Social'),
(130, 'nav_social_ar', 'الشبكات'),
(131, 'nav_news_fr', 'Actualités'),
(132, 'nav_news_en', 'News'),
(133, 'nav_news_ar', 'الأخبار'),
(134, 'home_discover_eyebrow_fr', 'Découvrir Bazma'),
(135, 'home_discover_eyebrow_en', 'Discover Bazma'),
(136, 'home_discover_eyebrow_ar', 'اكتشف بازمة'),
(137, 'home_discover_title_fr', 'Un territoire à documenter avec ses habitants'),
(138, 'home_discover_title_en', 'A place to document with its residents'),
(139, 'home_discover_title_ar', 'قرية نوثقها مع أهلها'),
(140, 'home_images_eyebrow_fr', 'Images'),
(141, 'home_images_eyebrow_en', 'Images'),
(142, 'home_images_eyebrow_ar', 'الصور'),
(143, 'home_images_title_fr', 'Palmeraies, lumière du désert et vie locale'),
(144, 'home_images_title_en', 'Palm groves, desert light and local life'),
(145, 'home_images_title_ar', 'النخيل، ضوء الصحراء والحياة المحلية'),
(146, 'home_associations_eyebrow_fr', 'Associations locales'),
(147, 'home_associations_eyebrow_en', 'Local associations'),
(148, 'home_associations_eyebrow_ar', 'الجمعيات المحلية'),
(149, 'home_associations_title_fr', 'Associations et structures actives autour de Bazma'),
(150, 'home_associations_title_en', 'Associations and active local structures around Bazma'),
(151, 'home_associations_title_ar', 'جمعيات وهياكل نشطة حول بازمة'),
(152, 'home_associations_text_fr', 'Cette liste peut être complétée depuis le CMS dès qu’une source fiable est disponible.'),
(153, 'home_associations_text_en', 'This list can be completed from the CMS whenever a reliable source is available.'),
(154, 'home_associations_text_ar', 'يمكن إكمال هذه القائمة من نظام الإدارة كلما توفر مصدر موثوق.'),
(155, 'home_social_eyebrow_fr', 'Bazma sur les réseaux'),
(156, 'home_social_eyebrow_en', 'Bazma on social media'),
(157, 'home_social_eyebrow_ar', 'بازمة على الشبكات'),
(158, 'home_social_title_fr', 'Les traces publiques de Bazma'),
(159, 'home_social_title_en', 'Public traces of Bazma'),
(160, 'home_social_title_ar', 'آثار بازمة المنشورة'),
(161, 'home_social_text_fr', 'Liens vers les pages et publications publiques liées à Bazma, à valider avant reprise de photos.'),
(162, 'home_social_text_en', 'Links to public pages and posts related to Bazma, to validate before reusing photos.'),
(163, 'home_social_text_ar', 'روابط لصفحات ومنشورات عامة حول بازمة، مع التثبت قبل استعمال الصور.'),
(164, 'home_news_eyebrow_fr', 'Actualités locales'),
(165, 'home_news_eyebrow_en', 'Local news'),
(166, 'home_news_eyebrow_ar', 'أخبار محلية'),
(167, 'home_news_title_fr', 'Actualités, événements et initiatives de Bazma'),
(168, 'home_news_title_en', 'Bazma news, events and initiatives'),
(169, 'home_news_title_ar', 'أخبار بازمة وفعالياتها ومبادراتها'),
(170, 'home_news_text_fr', 'Suivez les nouvelles publiées autour de Bazma: annonces locales, activités de jeunesse, actions associatives, sport, photos autorisées et événements importants du village.'),
(171, 'home_news_text_en', 'Follow updates from Bazma: local announcements, youth activities, association work, sports, authorized photos and important village events.'),
(172, 'home_news_text_ar', 'تابع مستجدات بازمة: الإعلانات المحلية، أنشطة الشباب، أعمال الجمعيات، الرياضة، الصور المرخصة والأحداث المهمة في القرية.'),
(173, 'read_more_fr', 'Lire'),
(174, 'read_more_en', 'Read'),
(175, 'read_more_ar', 'اقرأ'),
(176, 'source_label_fr', 'Source'),
(177, 'source_label_en', 'Source'),
(178, 'source_label_ar', 'المصدر'),
(179, 'news_source_label_fr', 'Lire la source'),
(180, 'news_source_label_en', 'Read source'),
(181, 'news_source_label_ar', 'قراءة المصدر'),
(182, 'planned_label_fr', 'À planifier'),
(183, 'planned_label_en', 'Planned'),
(184, 'planned_label_ar', 'قيد البرمجة'),
(185, 'no_news_fr', 'Aucune actualité publiée'),
(186, 'no_news_en', 'No published news'),
(187, 'no_news_ar', 'لا توجد أخبار منشورة');

-- --------------------------------------------------------

--
-- Structure de la table `social_link`
--

DROP TABLE IF EXISTS `social_link`;
CREATE TABLE IF NOT EXISTS `social_link` (
  `id` int NOT NULL AUTO_INCREMENT,
  `platform` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(160) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_en` varchar(160) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_ar` varchar(160) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `summary` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `summary_en` longtext COLLATE utf8mb4_unicode_ci,
  `summary_ar` longtext COLLATE utf8mb4_unicode_ci,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `featured` tinyint(1) NOT NULL,
  `position` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `social_link`
--

INSERT INTO `social_link` (`id`, `platform`, `title`, `title_en`, `title_ar`, `summary`, `summary_en`, `summary_ar`, `url`, `image_url`, `category`, `featured`, `position`) VALUES
(33, 'Facebook', 'Airport kebili-Bazma', 'Airport kebili-Bazma', 'Airport kebili-Bazma', 'Page publique avec photos, albums, vidéos et publications autour de Bazma.', 'Public page with photos, albums, videos and posts around Bazma.', 'صفحة عامة تضم صورا وألبومات وفيديوهات ومنشورات حول بازمة.', 'https://www.facebook.com/AirportBazma/', '/assets/bazma-airport.webp', 'Page', 1, 1),
(34, 'Facebook', 'Photos Airport kebili-Bazma', 'Airport kebili-Bazma photos', 'صور Airport kebili-Bazma', 'Albums publics à vérifier pour récupérer des images de Bazma avec accord.', 'Public albums to review for Bazma images with permission.', 'ألبومات عامة يمكن مراجعتها للحصول على صور بازمة بإذن.', 'https://www.facebook.com/AirportBazma/photos/', '/assets/bazma-airport.webp', 'Photos', 1, 2),
(35, 'Facebook', 'دار الشباب بازمة', 'Bazma youth center', 'دار الشباب بازمة', 'Page Facebook locale liée aux activités, annonces et événements de la jeunesse à Bazma.', 'Local Facebook page linked to youth activities, announcements and events in Bazma.', 'صفحة محلية مرتبطة بأنشطة وإعلانات وتظاهرات الشباب في بازمة.', 'https://www.facebook.com/p/%D8%AF%D8%A7%D8%B1-%D8%A7%D9%84%D8%B4%D8%A8%D8%A7%D8%A8-%D8%A8%D8%A7%D8%B2%D9%85%D8%A9-100089146635794/', '/assets/bazma-youth.webp', 'Jeunesse', 1, 3),
(36, 'Facebook', 'Bazma بازمة حكاية بلد', 'Bazma story page', 'بازمة حكاية بلد', 'Page sociale centrée sur des nouvelles, réussites et fragments de mémoire de Bazma.', 'Social page focused on news, achievements and memory fragments from Bazma.', 'صفحة اجتماعية حول أخبار ونجاحات وذاكرة بازمة.', 'https://www.facebook.com/p/Bazma-%D8%A8%D8%A7%D8%B2%D9%85%D8%A9-%D8%AD%D9%83%D8%A7%D9%8A%D8%A9-%D8%A8%D9%84%D8%AF-bazma-2-100071547231876/', '/assets/bazma-memory.webp', 'Mémoire', 1, 4),
(37, 'Facebook', 'Camera Andalib - عشوية الخيل', 'Camera Andalib - horse evening', 'كاميرا العندليب - عشوية الخيل', 'Publication récente avec photos de عشوية الخيل / ثاني العيد à قرية بازمة، قبلي.', 'Recent post with photos from the horse evening / Eid event in Bazma village.', 'منشور حديث بصور عشوية الخيل / ثاني العيد في قرية بازمة، قبلي.', 'https://www.facebook.com/andalibstudio/posts/%D8%A8%D8%B9%D8%B6-%D9%85%D9%86-%D8%A7%D9%84%D8%B5%D9%88%D8%B1-%D9%84%D9%85%D9%88%D8%A7%D9%83%D8%A8%D8%A9-%D9%83%D8%A7%D9%85%D9%8A%D8%B1%D8%A7-%D8%A7%D9%84%D8%B9%D9%86%D8%AF%D9%84%D9%8A%D8%A8-%D9%84%D8%B9%D8%B4', '/assets/bazma-horses.webp', 'Traditions', 1, 5),
(38, 'Facebook', 'Commune Kebili - match Bazma', 'Kebili commune - Bazma match', 'بلدية قبلي - مباراة بازمة', 'Publication publique sur une rencontre sportive impliquant Bazma.', 'Public post about a sports match involving Bazma.', 'منشور عام حول مقابلة رياضية شاركت فيها بازمة.', 'https://www.facebook.com/commune.kebili/posts/%D8%B5%D9%88%D8%B1-%D9%85%D9%86-%D9%85%D8%A8%D8%A7%D8%B1%D8%A7%D8%A9-%D8%A8%D8%A7%D8%B2%D9%85%D8%A9-%D9%88-%D8%A7%D9%84%D8%B1%D8%AD%D9%85%D8%A7%D8%AA-%D9%8A%D9%88%D9%85-%D8%A7%D9%85%D8%B3-%D8%A8%D8%A7%D9%84%D9', '/assets/bazma-sport.webp', 'Sport', 1, 6),
(39, 'Facebook', 'Jeun’ESS - Maison des jeunes de Bazma', 'Jeun’ESS - Bazma youth center', 'Jeun’ESS - دار الشباب بازمة', 'Vidéo/projet mentionnant la Maison des jeunes de Bazma, Kebili.', 'Video/project mentioning the Bazma youth center, Kebili.', 'فيديو/مشروع يذكر دار الشباب بازمة، قبلي.', 'https://www.facebook.com/jeuness.eu4youth/videos/limitless-generation-a%CC%80-la-maison-des-jeunes-de-bazma-kebili/1015270436479405/', '/assets/bazma-youth.webp', 'Projet', 1, 7),
(40, 'Facebook', 'Elite Football - Académie Bazma', 'Elite Football - Bazma academy', 'Elite Football - أكاديمية بازمة', 'Publication sportive récente mentionnant une académie de Bazma.', 'Recent sports post mentioning a Bazma academy.', 'منشور رياضي حديث يذكر أكاديمية بازمة.', 'https://www.facebook.com/Elite.football.academie.kebili/posts/%D9%81%D8%B1%D8%B9-%D8%A7%D9%84%D8%A8%D8%B1%D8%BA%D9%88%D8%AB%D9%8A%D8%A9-%D8%A8%D8%B9%D8%B6-%D8%B5%D9%88%D8%B1-%D8%A7%D9%84%D9%85%D8%A8%D8%A7%D8%B1%D9%8A%D8%A7%D8%AA-%D9%85%D8%B9-%D8%A7%D9%83%', '/assets/bazma-sport.webp', 'Sport', 1, 8);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `page_media`
--
ALTER TABLE `page_media`
  ADD CONSTRAINT `FK_E0F3026EC4663E4` FOREIGN KEY (`page_id`) REFERENCES `page` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
