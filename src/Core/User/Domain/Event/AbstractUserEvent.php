<?php

declare(strict_types=1);

namespace App\Core\User\Domain\Event;

use App\Common\EventManager\EventInterface;
use App\Core\User\Domain\User;

abstract class AbstractUserEvent implements EventInterface
{
    public function __construct(
        protected readonly User $user,
    )
    {
    }
}