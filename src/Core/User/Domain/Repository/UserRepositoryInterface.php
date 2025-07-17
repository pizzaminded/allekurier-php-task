<?php

namespace App\Core\User\Domain\Repository;

use App\Core\User\Domain\Exception\UserNotFoundException;
use App\Core\User\Domain\Status\UserStatus;
use App\Core\User\Domain\User;

interface UserRepositoryInterface
{
    /**
     * @throws UserNotFoundException
     */
    public function getByEmail(string $email): User;

    public function existsByEmail(string $email): bool;

    public function store(User $user): void;

    /**
     * @param UserStatus $status
     * @return array<User>
     */
    public function getUsersByStatus(UserStatus $status): array;
}
