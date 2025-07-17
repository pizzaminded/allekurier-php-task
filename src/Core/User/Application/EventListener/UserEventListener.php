<?php

declare(strict_types=1);

namespace App\Core\User\Application\EventListener;


use App\Core\User\Domain\Event\UserCreatedEvent;
use App\Core\User\Domain\Notification\UserNotificationInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class UserEventListener implements EventSubscriberInterface
{

    public function __construct(
        private readonly UserNotificationInterface $userNotificationService
    )
    {
    }


    public static function getSubscribedEvents(): array
    {
        return [
            UserCreatedEvent::class => 'onUserCreated'
        ];
    }

    public function onUserCreated(
        UserCreatedEvent $event
    ): void
    {
        $this
            ->userNotificationService
            ->sendWelcomeEmail($event->getUserEmail());
    }
}