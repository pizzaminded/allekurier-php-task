<?php

declare(strict_types=1);

namespace App\Core\User\Application\Query;

use App\Core\User\Application\DTO\UserDTO;
use App\Core\User\Domain\Repository\UserRepositoryInterface;
use App\Core\User\Domain\Status\UserStatus;
use App\Core\User\Domain\User;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class GetInactiveUsersHandler
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
    )
    {
    }

    public function __invoke(GetInactiveUsersQuery $query): array
    {
        $users = $this
            ->userRepository
            ->getUsersByStatus(UserStatus::INACTIVE);

        return array_map(
            fn(User $user) => new UserDTO($user->getEmail()),
            $users
        );
    }
}