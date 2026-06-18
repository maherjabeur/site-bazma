<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260618114500 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add public profile fields to admin users';
    }

    public function up(Schema $schema): void
    {
        $table = $this->identifier('admin_user');
        $this->addSql(sprintf('ALTER TABLE %s ADD %s VARCHAR(160) DEFAULT NULL', $table, $this->identifier('profession')));
        $this->addSql(sprintf('ALTER TABLE %s ADD %s VARCHAR(255) DEFAULT NULL', $table, $this->identifier('facebook_url')));
        $this->addSql(sprintf('ALTER TABLE %s ADD %s VARCHAR(255) DEFAULT NULL', $table, $this->identifier('profile_image_url')));
    }

    public function down(Schema $schema): void
    {
        $table = $this->identifier('admin_user');
        $this->addSql(sprintf('ALTER TABLE %s DROP COLUMN %s', $table, $this->identifier('profile_image_url')));
        $this->addSql(sprintf('ALTER TABLE %s DROP COLUMN %s', $table, $this->identifier('facebook_url')));
        $this->addSql(sprintf('ALTER TABLE %s DROP COLUMN %s', $table, $this->identifier('profession')));
    }

    private function identifier(string $name): string
    {
        return $this->isPostgreSql()
            ? '"'.str_replace('"', '""', $name).'"'
            : '`'.str_replace('`', '``', $name).'`';
    }

    private function isPostgreSql(): bool
    {
        return str_contains($this->connection->getDatabasePlatform()::class, 'PostgreSQL');
    }
}
