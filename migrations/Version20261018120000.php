<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Platforms\AbstractMySQLPlatform;
use Doctrine\DBAL\Platforms\PostgreSQLPlatform;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20261018120000 extends AbstractMigration
{
    /**
     * Human-entered content and URLs that must not be constrained by VARCHAR.
     *
     * @var array<string, array<string, array{int, bool}>>
     */
    private const COLUMNS = [
        'event' => [
            'title' => [160, false],
            'title_en' => [160, true],
            'title_ar' => [160, true],
            'location' => [255, false],
            'source_url' => [255, true],
            'image_url' => [255, true],
            'excerpt' => [220, true],
            'excerpt_en' => [220, true],
            'excerpt_ar' => [220, true],
        ],
        'page' => [
            'title' => [120, false],
            'title_en' => [120, true],
            'title_ar' => [120, true],
            'summary' => [180, false],
            'summary_en' => [180, true],
            'summary_ar' => [180, true],
            'image_url' => [255, true],
        ],
        'gallery_image' => [
            'title' => [160, false],
            'title_en' => [160, true],
            'title_ar' => [160, true],
            'image_url' => [255, false],
            'credit' => [255, true],
            'source_url' => [255, true],
        ],
        'page_media' => [
            'title' => [180, false],
            'image_url' => [255, false],
            'caption' => [255, true],
        ],
        'community_organization' => [
            'name' => [160, false],
            'name_en' => [160, true],
            'name_ar' => [160, true],
            'url' => [255, true],
            'image_url' => [255, false],
        ],
        'social_link' => [
            'title' => [160, false],
            'title_en' => [160, true],
            'title_ar' => [160, true],
            'url' => [255, false],
            'image_url' => [255, false],
        ],
        'admin_user' => [
            'name' => [120, false],
            'profession' => [160, true],
            'facebook_url' => [255, true],
            'profile_image_url' => [255, true],
        ],
        'content_approval_request' => [
            'entity_label' => [180, false],
        ],
    ];

    public function getDescription(): string
    {
        return 'Convert potentially long content and URL fields from VARCHAR to TEXT';
    }

    public function up(Schema $schema): void
    {
        $platform = $this->connection->getDatabasePlatform();
        $this->abortIf(
            !$platform instanceof AbstractMySQLPlatform && !$platform instanceof PostgreSQLPlatform,
            'This migration supports MySQL/MariaDB and PostgreSQL only.',
        );

        foreach (self::COLUMNS as $table => $columns) {
            if (!$schema->hasTable($table)) {
                continue;
            }

            foreach ($columns as $column => [, $nullable]) {
                if (!$schema->getTable($table)->hasColumn($column)) {
                    continue;
                }

                $quotedTable = $platform->quoteIdentifier($table);
                $quotedColumn = $platform->quoteIdentifier($column);

                if ($platform instanceof AbstractMySQLPlatform) {
                    $nullSql = $nullable ? 'NULL' : 'NOT NULL';
                    $this->addSql("ALTER TABLE {$quotedTable} MODIFY {$quotedColumn} LONGTEXT {$nullSql}");
                } else {
                    $this->addSql("ALTER TABLE {$quotedTable} ALTER COLUMN {$quotedColumn} TYPE TEXT");
                }
            }
        }
    }

    public function down(Schema $schema): void
    {
        $platform = $this->connection->getDatabasePlatform();
        $this->abortIf(
            !$platform instanceof AbstractMySQLPlatform && !$platform instanceof PostgreSQLPlatform,
            'This migration supports MySQL/MariaDB and PostgreSQL only.',
        );

        foreach (self::COLUMNS as $table => $columns) {
            if (!$schema->hasTable($table)) {
                continue;
            }

            foreach ($columns as $column => [$length, $nullable]) {
                if (!$schema->getTable($table)->hasColumn($column)) {
                    continue;
                }

                $quotedTable = $platform->quoteIdentifier($table);
                $quotedColumn = $platform->quoteIdentifier($column);
                $nullSql = $nullable ? 'NULL' : 'NOT NULL';

                if ($platform instanceof AbstractMySQLPlatform) {
                    $this->addSql("ALTER TABLE {$quotedTable} MODIFY {$quotedColumn} VARCHAR({$length}) {$nullSql}");
                } else {
                    $this->addSql("ALTER TABLE {$quotedTable} ALTER COLUMN {$quotedColumn} TYPE VARCHAR({$length})");
                }
            }
        }
    }
}
