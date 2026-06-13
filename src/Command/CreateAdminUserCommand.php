<?php

namespace App\Command;

use App\Entity\AdminUser;
use App\Repository\AdminUserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(name: 'app:create-admin-user', description: 'Crée ou met à jour un compte administrateur CMS.')]
class CreateAdminUserCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly AdminUserRepository $users,
        private readonly UserPasswordHasherInterface $hasher,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::REQUIRED, 'Email du compte')
            ->addArgument('password', InputArgument::REQUIRED, 'Mot de passe')
            ->addArgument('name', InputArgument::OPTIONAL, 'Nom affiché', 'Administrateur');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $email = (string) $input->getArgument('email');
        $password = (string) $input->getArgument('password');
        $name = (string) $input->getArgument('name');

        $user = $this->users->findOneBy(['email' => strtolower(trim($email))]) ?? new AdminUser();
        $user
            ->setEmail($email)
            ->setName($name)
            ->setActive(true)
            ->setRoles(['ROLE_SUPER_ADMIN']);
        $user->setPassword($this->hasher->hashPassword($user, $password));

        $this->em->persist($user);
        $this->em->flush();

        $output->writeln('Compte administrateur prêt.');

        return Command::SUCCESS;
    }
}
