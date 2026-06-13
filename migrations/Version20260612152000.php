<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260612152000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add community organizations and improve news fields';
    }

    public function up(Schema $schema): void
    {
        if ($this->isPostgreSql()) {
            return;
        }

        $this->addSql('CREATE TABLE community_organization (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(160) NOT NULL, name_en VARCHAR(160) DEFAULT NULL, name_ar VARCHAR(160) DEFAULT NULL, type VARCHAR(80) NOT NULL, description LONGTEXT NOT NULL, description_en LONGTEXT DEFAULT NULL, description_ar LONGTEXT DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, image_url VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL, position INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql("ALTER TABLE event ADD category VARCHAR(80) NOT NULL DEFAULT 'Actualite', ADD source_url VARCHAR(255) DEFAULT NULL, ADD featured TINYINT(1) NOT NULL DEFAULT 1, ADD position INT NOT NULL DEFAULT 0");
    }

    public function down(Schema $schema): void
    {
        if ($this->isPostgreSql()) {
            return;
        }

        $this->addSql('DROP TABLE community_organization');
        $this->addSql('ALTER TABLE event DROP category, DROP source_url, DROP featured, DROP position');
    }

    private function isPostgreSql(): bool
    {
        return str_contains($this->connection->getDatabasePlatform()::class, 'PostgreSQL');
    }
}
