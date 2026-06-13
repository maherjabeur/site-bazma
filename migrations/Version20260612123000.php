<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260612123000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create custom CMS tables for Bazma showcase site';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(160) NOT NULL, event_date DATE DEFAULT NULL, location VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, published TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gallery_image (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(160) NOT NULL, image_url VARCHAR(255) NOT NULL, credit VARCHAR(255) DEFAULT NULL, source_url VARCHAR(255) DEFAULT NULL, featured TINYINT(1) NOT NULL, position INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(120) NOT NULL, slug VARCHAR(140) NOT NULL, summary VARCHAR(180) NOT NULL, body LONGTEXT NOT NULL, image_url VARCHAR(255) DEFAULT NULL, published TINYINT(1) NOT NULL, position INT NOT NULL, UNIQUE INDEX UNIQ_140AB620989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE site_setting (id INT AUTO_INCREMENT NOT NULL, setting_key VARCHAR(80) NOT NULL, setting_value LONGTEXT NOT NULL, UNIQUE INDEX UNIQ_57B40A2045D6295E (setting_key), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE gallery_image');
        $this->addSql('DROP TABLE page');
        $this->addSql('DROP TABLE site_setting');
    }
}
