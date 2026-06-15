<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260615130000 extends AbstractMigration
{
    private const SLUG = 'faire-un-don';

    public function getDescription(): string
    {
        return 'Create protected donation page content';
    }

    public function up(Schema $schema): void
    {
        $params = [
            'title' => 'Faire un don',
            'title_en' => 'Make a donation',
            'title_ar' => 'تبرع',
            'slug' => self::SLUG,
            'summary' => 'Soutenir les actions locales et la mémoire vivante de Bazma.',
            'summary_en' => 'Support local initiatives and the living memory of Bazma.',
            'summary_ar' => 'دعم المبادرات المحلية والذاكرة الحية لبازمة.',
            'body' => $this->bodyFr(),
            'body_en' => $this->bodyEn(),
            'body_ar' => $this->bodyAr(),
            'image_url' => '/assets/bazma-memory.webp',
            'published' => true,
            'position' => 90,
        ];

        $this->addSql($this->upsertSql(), $params, [
            'published' => ParameterType::BOOLEAN,
            'position' => ParameterType::INTEGER,
        ]);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DELETE FROM '.$this->identifier('page').' WHERE '.$this->identifier('slug').' = :slug', ['slug' => self::SLUG]);
    }

    private function upsertSql(): string
    {
        $columns = ['title', 'title_en', 'title_ar', 'slug', 'summary', 'summary_en', 'summary_ar', 'body', 'body_en', 'body_ar', 'image_url', 'published', 'position'];
        $quotedColumns = array_map($this->identifier(...), $columns);
        $params = array_map(fn (string $column): string => ':'.$column, $columns);

        if ($this->isPostgreSql()) {
            $updates = array_map(
                fn (string $column): string => $this->identifier($column).' = EXCLUDED.'.$this->identifier($column),
                array_filter($columns, fn (string $column): bool => $column !== 'slug')
            );

            return sprintf(
                'INSERT INTO %s (%s) VALUES (%s) ON CONFLICT (%s) DO UPDATE SET %s',
                $this->identifier('page'),
                implode(', ', $quotedColumns),
                implode(', ', $params),
                $this->identifier('slug'),
                implode(', ', $updates)
            );
        }

        $updates = array_map(
            fn (string $column): string => $this->identifier($column).' = VALUES('.$this->identifier($column).')',
            array_filter($columns, fn (string $column): bool => $column !== 'slug')
        );

        return sprintf(
            'INSERT INTO %s (%s) VALUES (%s) ON DUPLICATE KEY UPDATE %s',
            $this->identifier('page'),
            implode(', ', $quotedColumns),
            implode(', ', $params),
            implode(', ', $updates)
        );
    }

    private function bodyFr(): string
    {
        return '<p>Vous pouvez soutenir les actions locales de Bazma par virement bancaire.</p><h2>Coordonnées de virement</h2><ul><li><strong>Banque:</strong> Poste Tunisienne</li><li><strong>Titulaire:</strong> JABEUR MAHER BEN MOHAMED</li><li><strong>Agence:</strong> CEF Gabes - BAZMA</li><li><strong>IBAN:</strong> TN59 1770 6000 0003 2863 5988</li><li><strong>BIC:</strong> LPTNTNTT</li></ul><p>Cette page est protégée dans le CMS: elle peut être modifiée, mais elle ne doit pas être supprimée.</p>';
    }

    private function bodyEn(): string
    {
        return '<p>You can support local Bazma initiatives by bank transfer.</p><h2>Bank transfer details</h2><ul><li><strong>Bank:</strong> Poste Tunisienne</li><li><strong>Account holder:</strong> JABEUR MAHER BEN MOHAMED</li><li><strong>Branch:</strong> CEF Gabes - BAZMA</li><li><strong>IBAN:</strong> TN59 1770 6000 0003 2863 5988</li><li><strong>BIC:</strong> LPTNTNTT</li></ul><p>This page is protected in the CMS: it can be edited, but it must not be deleted.</p>';
    }

    private function bodyAr(): string
    {
        return '<p>يمكنكم دعم المبادرات المحلية في بازمة عبر تحويل بنكي.</p><h2>معلومات التحويل</h2><ul><li><strong>البنك:</strong> Poste Tunisienne</li><li><strong>صاحب الحساب:</strong> JABEUR MAHER BEN MOHAMED</li><li><strong>الفرع:</strong> CEF Gabes - BAZMA</li><li><strong>IBAN:</strong> TN59 1770 6000 0003 2863 5988</li><li><strong>BIC:</strong> LPTNTNTT</li></ul><p>هذه الصفحة محمية داخل نظام الإدارة: يمكن تعديل محتواها، لكن لا يمكن حذفها.</p>';
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
