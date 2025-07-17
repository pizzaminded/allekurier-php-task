<?php

declare(strict_types=1);

namespace App\Core\User\Infrastructure\Persistance;

use App\Core\User\Domain\Exception\UserNotFoundException;
use App\Core\User\Domain\Repository\UserRepositoryInterface;
use App\Core\User\Domain\Status\UserStatus;
use App\Core\User\Domain\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use Psr\EventDispatcher\EventDispatcherInterface;

class DoctrineUserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{

    public function __construct(
        ManagerRegistry                  $registry,
        private EventDispatcherInterface $eventDispatcher
    )
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @throws NonUniqueResultException
     */
    public function getByEmail(string $email): User
    {
        $user = $this->createQueryBuilder('u')
            ->where('u.email = :user_email')
            ->setParameter(':user_email', $email)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        if (null === $user) {
            throw new UserNotFoundException('Użytkownik nie istnieje');
        }

        return $user;
    }


    public function store(User $user): void
    {
        $this->_em->persist($user);

        foreach ($user->pullEvents() as $event) {
            $this
                ->eventDispatcher
                ->dispatch($event);
        }
    }

    public function existsByEmail(string $email): bool
    {
        return $this->count(['email' => $email]) > 0;
    }

    public function getUsersByStatus(UserStatus $status): array
    {
        return $this->findBy([
            'status' => $status,
        ]);
    }
}
