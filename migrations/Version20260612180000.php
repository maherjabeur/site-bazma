<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260612180000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add CMS users, advanced news fields and page media';
    }

    public function up(Schema $schema): void
    {
        if ($this->isPostgreSql()) {
            return;
        }

        $this->addSql('CREATE TABLE admin_user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, name VARCHAR(120) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page_media (id INT AUTO_INCREMENT NOT NULL, page_id INT NOT NULL, title VARCHAR(180) NOT NULL, image_url VARCHAR(255) NOT NULL, caption VARCHAR(255) DEFAULT NULL, position INT NOT NULL, INDEX IDX_E0F3026EC4663E4 (page_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE page_media ADD CONSTRAINT FK_E0F3026EC4663E4 FOREIGN KEY (page_id) REFERENCES page (id) ON DELETE CASCADE');
        $this->addSql("ALTER TABLE event ADD slug VARCHAR(170) NOT NULL, ADD image_url VARCHAR(255) DEFAULT NULL, ADD excerpt VARCHAR(220) DEFAULT NULL, ADD excerpt_en VARCHAR(220) DEFAULT NULL, ADD excerpt_ar VARCHAR(220) DEFAULT NULL");
        $this->addSql("UPDATE event SET slug = LOWER(REPLACE(REPLACE(REPLACE(CONCAT('actualite-', id, '-', title), ' ', '-'), '''', ''), '\"', '')) WHERE slug = ''");
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3BAE0AA989D9B62 ON event (slug)');
    }

    public function down(Schema $schema): void
    {
        if ($this->isPostgreSql()) {
            return;
        }

        $this->addSql('ALTER TABLE page_media DROP FOREIGN KEY FK_E0F3026EC4663E4');
        $this->addSql('DROP TABLE admin_user');
        $this->addSql('DROP TABLE page_media');
        $this->addSql('DROP INDEX UNIQ_3BAE0AA989D9B62 ON event');
        $this->addSql('ALTER TABLE event DROP slug, DROP image_url, DROP excerpt, DROP excerpt_en, DROP excerpt_ar');
    }

    private function isPostgreSql(): bool
    {
        return str_contains($this->connection->getDatabasePlatform()::class, 'PostgreSQL');
    }
}
