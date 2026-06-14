<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260614113000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add archive status to news events';
    }

    public function up(Schema $schema): void
    {
        if ($this->isPostgreSql()) {
            $this->addSql(sprintf('ALTER TABLE %s ADD COLUMN IF NOT EXISTS archived BOOLEAN NOT NULL DEFAULT FALSE', $this->identifier('event')));

            return;
        }

        if ($this->isMySql()) {
            $this->addSql(sprintf('ALTER TABLE %s ADD archived TINYINT(1) NOT NULL DEFAULT 0', $this->identifier('event')));

            return;
        }

        $this->addSql(sprintf('ALTER TABLE %s ADD archived BOOLEAN NOT NULL DEFAULT 0', $this->identifier('event')));
    }

    public function down(Schema $schema): void
    {
        if ($this->isPostgreSql()) {
            $this->addSql(sprintf('ALTER TABLE %s DROP COLUMN IF EXISTS archived', $this->identifier('event')));

            return;
        }

        $this->addSql(sprintf('ALTER TABLE %s DROP COLUMN archived', $this->identifier('event')));
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
