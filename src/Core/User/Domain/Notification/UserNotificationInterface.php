<?php

declare(strict_types=1);

namespace App\Core\User\Domain\Notification;

interface UserNotificationInterface
{
    public function sendWelcomeEmail(string $email): void;
}