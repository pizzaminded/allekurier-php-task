<?php

declare(strict_types=1);

namespace App\Core\User\UserInterface\Cli;

use App\Core\User\Application\Command\CreateUser\CreateUserCommand;
use App\Core\User\Application\Exception\UserApplicationException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(
    name: 'app:user:create',
    description: 'Tworzy nowego użytkownika'
)]
class CreateUser extends Command
{
    private SymfonyStyle $io;

    public function __construct(
        private readonly MessageBusInterface $messageBus,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('email', InputArgument::REQUIRED);
    }

    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $this->io = new SymfonyStyle($input, $output);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var string $email */
        $email = $input->getArgument('email');

        $this
            ->messageBus
            ->dispatch(
                new CreateUserCommand($email)
            );

        return Command::SUCCESS;
    }
}