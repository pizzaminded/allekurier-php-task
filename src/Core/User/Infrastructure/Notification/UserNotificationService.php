<?php

declare(strict_types=1);

namespace App\Core\User\Infrastructure\Notification;

use App\Common\Mailer\MailerInterface;
use App\Core\User\Domain\Notification\UserNotificationInterface;

class UserNotificationService implements UserNotificationInterface
{

    public function __construct(
        private readonly MailerInterface $mailer
    )
    {
    }

    public function sendWelcomeEmail(string $email): void
    {
        $this
            ->mailer
            ->send(
                $email,
                'Zarejestrowano twoje konto w systemie!',
                'Zarejestrowano konto w systemie. Aktywacja konta trwa do 24h'
            );
    }


}