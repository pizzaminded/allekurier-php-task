<?php

declare(strict_types=1);

namespace App\Core\User\Domain\Event;

use App\Core\User\Domain\User;

abstract class AbstractUserEvent
{
    public function __construct(
        protected readonly User $user,
    )
    {
    }
}