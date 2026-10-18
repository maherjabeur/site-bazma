-- Bazma CMS - MySQL/MariaDB production upgrade
-- Converts user-entered content and URL fields to LONGTEXT without losing data.
-- Run this file once on the server database before deploying the updated code.

ALTER TABLE `event`
    MODIFY `title` LONGTEXT NOT NULL,
    MODIFY `title_en` LONGTEXT NULL,
    MODIFY `title_ar` LONGTEXT NULL,
    MODIFY `location` LONGTEXT NOT NULL,
    MODIFY `source_url` LONGTEXT NULL,
    MODIFY `image_url` LONGTEXT NULL,
    MODIFY `excerpt` LONGTEXT NULL,
    MODIFY `excerpt_en` LONGTEXT NULL,
    MODIFY `excerpt_ar` LONGTEXT NULL;

ALTER TABLE `page`
    MODIFY `title` LONGTEXT NOT NULL,
    MODIFY `title_en` LONGTEXT NULL,
    MODIFY `title_ar` LONGTEXT NULL,
    MODIFY `summary` LONGTEXT NOT NULL,
    MODIFY `summary_en` LONGTEXT NULL,
    MODIFY `summary_ar` LONGTEXT NULL,
    MODIFY `image_url` LONGTEXT NULL;

ALTER TABLE `gallery_image`
    MODIFY `title` LONGTEXT NOT NULL,
    MODIFY `title_en` LONGTEXT NULL,
    MODIFY `title_ar` LONGTEXT NULL,
    MODIFY `image_url` LONGTEXT NOT NULL,
    MODIFY `credit` LONGTEXT NULL,
    MODIFY `source_url` LONGTEXT NULL;

ALTER TABLE `page_media`
    MODIFY `title` LONGTEXT NOT NULL,
    MODIFY `image_url` LONGTEXT NOT NULL,
    MODIFY `caption` LONGTEXT NULL;

ALTER TABLE `community_organization`
    MODIFY `name` LONGTEXT NOT NULL,
    MODIFY `name_en` LONGTEXT NULL,
    MODIFY `name_ar` LONGTEXT NULL,
    MODIFY `url` LONGTEXT NULL,
    MODIFY `image_url` LONGTEXT NOT NULL;

ALTER TABLE `social_link`
    MODIFY `title` LONGTEXT NOT NULL,
    MODIFY `title_en` LONGTEXT NULL,
    MODIFY `title_ar` LONGTEXT NULL,
    MODIFY `url` LONGTEXT NOT NULL,
    MODIFY `image_url` LONGTEXT NOT NULL;

ALTER TABLE `admin_user`
    MODIFY `name` LONGTEXT NOT NULL,
    MODIFY `profession` LONGTEXT NULL,
    MODIFY `facebook_url` LONGTEXT NULL,
    MODIFY `profile_image_url` LONGTEXT NULL;

ALTER TABLE `content_approval_request`
    MODIFY `entity_label` LONGTEXT NOT NULL;
