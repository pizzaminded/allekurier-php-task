<?php

declare(strict_types=1);

namespace App\Core\User\Application\Command\CreateUser;

use App\Core\User\Application\Exception\InvalidEmailException;
use App\Core\User\Application\Exception\UserAlreadyExistsException;
use App\Core\User\Domain\Repository\UserRepositoryInterface;
use App\Core\User\Domain\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateUserCommandHandler
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly EntityManagerInterface  $entityManager,
    )
    {
    }

    public function __invoke(
        CreateUserCommand $command
    ): void
    {
        $email = $command->email;
        $this->assertEmailValid($email);

        $exists = $this
            ->userRepository
            ->existsByEmail($email);

        if ($exists) {
            throw new UserAlreadyExistsException(
                'Użytkownik z podanym adresem email widnieje w bazie!'
            );
        }

        $this
            ->userRepository
            ->store(
                new User($email)
            );

        $this
            ->entityManager
            ->flush();
    }

    private function assertEmailValid(string $emailAddress): void
    {
        if (!filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailException('Nieprawidłowy adres e-mail!');
        }
    }
}