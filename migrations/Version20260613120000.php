<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260613120000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Remove public sources section settings';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("DELETE FROM site_setting WHERE setting_key LIKE 'sources\\_%'");
    }

    public function down(Schema $schema): void
    {
    }
}
