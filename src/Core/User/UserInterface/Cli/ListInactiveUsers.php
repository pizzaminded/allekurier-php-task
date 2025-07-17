<?php

declare(strict_types=1);

namespace App\Core\User\UserInterface\Cli;

use App\Common\Bus\QueryBusInterface;
use App\Core\User\Application\DTO\UserDTO;
use App\Core\User\Application\Query\GetInactiveUsersQuery;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:user:list-inactive',
    description: 'Wyświetla wszystkich nieaktywnych użytkowników'
)]
class ListInactiveUsers extends Command
{

    public function __construct(
        private readonly QueryBusInterface $queryBus,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        /** @var array<UserDTO> $users */
        $users = $this
            ->queryBus
            ->dispatch(new GetInactiveUsersQuery());

        foreach ($users as $user) {
            $output->writeln(sprintf('<info>%s</info>', $user->email));
        }
        return Command::SUCCESS;
    }
}