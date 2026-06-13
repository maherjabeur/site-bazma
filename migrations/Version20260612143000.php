<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260612143000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add social links for Bazma public references';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE social_link (id INT AUTO_INCREMENT NOT NULL, platform VARCHAR(80) NOT NULL, title VARCHAR(160) NOT NULL, title_en VARCHAR(160) DEFAULT NULL, title_ar VARCHAR(160) DEFAULT NULL, summary LONGTEXT NOT NULL, summary_en LONGTEXT DEFAULT NULL, summary_ar LONGTEXT DEFAULT NULL, url VARCHAR(255) NOT NULL, image_url VARCHAR(255) NOT NULL, category VARCHAR(80) NOT NULL, featured TINYINT(1) NOT NULL, position INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE social_link');
    }
}
