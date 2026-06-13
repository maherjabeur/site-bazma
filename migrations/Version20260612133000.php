<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260612133000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add multilingual content fields';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE page ADD title_en VARCHAR(120) DEFAULT NULL, ADD title_ar VARCHAR(120) DEFAULT NULL, ADD summary_en VARCHAR(180) DEFAULT NULL, ADD summary_ar VARCHAR(180) DEFAULT NULL, ADD body_en LONGTEXT DEFAULT NULL, ADD body_ar LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE event ADD title_en VARCHAR(160) DEFAULT NULL, ADD title_ar VARCHAR(160) DEFAULT NULL, ADD description_en LONGTEXT DEFAULT NULL, ADD description_ar LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE gallery_image ADD title_en VARCHAR(160) DEFAULT NULL, ADD title_ar VARCHAR(160) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE page DROP title_en, DROP title_ar, DROP summary_en, DROP summary_ar, DROP body_en, DROP body_ar');
        $this->addSql('ALTER TABLE event DROP title_en, DROP title_ar, DROP description_en, DROP description_ar');
        $this->addSql('ALTER TABLE gallery_image DROP title_en, DROP title_ar');
    }
}
