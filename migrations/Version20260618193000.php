<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;

final class Version20260618193000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add content approval workflow requests';
    }

    public function up(Schema $schema): void
    {
        if ($schema->hasTable('content_approval_request')) {
            return;
        }

        $table = $schema->createTable('content_approval_request');
        $table->addColumn('id', Types::INTEGER, ['autoincrement' => true]);
        $table->addColumn('action', Types::STRING, ['length' => 20]);
        $table->addColumn('entity_class', Types::STRING, ['length' => 160]);
        $table->addColumn('entity_id', Types::INTEGER, ['notnull' => false]);
        $table->addColumn('entity_label', Types::STRING, ['length' => 180]);
        $table->addColumn('payload', Types::JSON);
        $table->addColumn('status', Types::STRING, ['length' => 20]);
        $table->addColumn('requested_by_id', Types::INTEGER, ['notnull' => false]);
        $table->addColumn('reviewed_by_id', Types::INTEGER, ['notnull' => false]);
        $table->addColumn('created_at', Types::DATETIME_IMMUTABLE);
        $table->addColumn('reviewed_at', Types::DATETIME_IMMUTABLE, ['notnull' => false]);
        $table->setPrimaryKey(['id']);
        $table->addIndex(['requested_by_id'], 'IDX_APPROVAL_REQUESTED_BY');
        $table->addIndex(['reviewed_by_id'], 'IDX_APPROVAL_REVIEWED_BY');
        $table->addIndex(['status'], 'IDX_APPROVAL_STATUS');
        $table->addForeignKeyConstraint('admin_user', ['requested_by_id'], ['id'], ['onDelete' => 'SET NULL'], 'FK_APPROVAL_REQUESTED_BY');
        $table->addForeignKeyConstraint('admin_user', ['reviewed_by_id'], ['id'], ['onDelete' => 'SET NULL'], 'FK_APPROVAL_REVIEWED_BY');
    }

    public function down(Schema $schema): void
    {
        if ($schema->hasTable('content_approval_request')) {
            $schema->dropTable('content_approval_request');
        }
    }
}
