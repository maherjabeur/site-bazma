<?php

namespace App\Command;

use Doctrine\DBAL\Connection;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpKernel\KernelInterface;

#[AsCommand(
    name: 'app:production-check',
    description: 'Vérifie la configuration du fichier .env et les services indispensables en production.',
)]
final class ProductionCheckCommand extends Command
{
    public function __construct(
        private readonly KernelInterface $kernel,
        private readonly Connection $connection,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $errors = [];

        if ($this->kernel->getEnvironment() !== 'prod') {
            $errors[] = 'APP_ENV doit être égal à prod.';
        }
        if ($this->kernel->isDebug()) {
            $errors[] = 'APP_DEBUG doit être égal à 0.';
        }

        $secret = $this->environmentValue('APP_SECRET');
        if (mb_strlen($secret) < 32) {
            $errors[] = 'APP_SECRET doit contenir au moins 32 caractères.';
        }

        $defaultUri = $this->environmentValue('DEFAULT_URI');
        if (parse_url($defaultUri, PHP_URL_SCHEME) !== 'https' || !parse_url($defaultUri, PHP_URL_HOST)) {
            $errors[] = 'DEFAULT_URI doit être une URL HTTPS complète.';
        }

        $databaseUrl = $this->environmentValue('DATABASE_URL');
        if ($databaseUrl === '' || !in_array(parse_url($databaseUrl, PHP_URL_SCHEME), ['mysql', 'mariadb', 'postgres', 'postgresql'], true)) {
            $errors[] = 'DATABASE_URL est absent ou son pilote n’est pas pris en charge.';
        }

        if ($this->environmentValue('DB_SERVER_VERSION') === '') {
            $errors[] = 'DB_SERVER_VERSION doit être défini dans .env.';
        }

        if ($this->environmentValue('TRANSLATION_PROVIDER') === '' || $this->environmentValue('TRANSLATION_API_URL') === '') {
            $errors[] = 'La configuration de traduction automatique est incomplète.';
        }

        foreach ([$this->kernel->getProjectDir().'/var', $this->kernel->getProjectDir().'/public/uploads'] as $directory) {
            if (!is_dir($directory) || !is_writable($directory)) {
                $errors[] = sprintf('Le dossier %s doit exister et être accessible en écriture.', $directory);
            }
        }

        if ($errors === []) {
            try {
                $this->connection->executeQuery('SELECT 1')->fetchOne();
            } catch (\Throwable) {
                $errors[] = 'La base de données définie dans DATABASE_URL est inaccessible.';
            }
        }

        if ($errors !== []) {
            $io->error($errors);

            return Command::FAILURE;
        }

        $io->success('Configuration production valide : .env, dossiers et base de données sont opérationnels.');

        return Command::SUCCESS;
    }

    private function environmentValue(string $name): string
    {
        return trim((string) ($_SERVER[$name] ?? $_ENV[$name] ?? getenv($name) ?: ''));
    }
}
