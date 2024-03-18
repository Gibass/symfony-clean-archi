<?php

namespace App\Infrastructure\Adapter\Repository;

use App\Domain\Security\Entity\User;
use App\Domain\Security\Gateway\UserGatewayInterface;
use App\Infrastructure\Doctrine\Entity\UserDoctrine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<UserDoctrine>
 *
 * @implements PasswordUpgraderInterface<UserDoctrine>
 *
 * @method UserDoctrine|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserDoctrine|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserDoctrine[]    findAll()
 * @method UserDoctrine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface, UserGatewayInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserDoctrine::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof UserDoctrine) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function isExist(string $email): bool
    {
        return (bool) $this->findOneBy(['email' => $email]);
    }

    public function register(User $user): void
    {
        $_user = (new UserDoctrine())
            ->setEmail($user->getEmail())
            ->setPlainPassword($user->getPassword())
        ;

        $this->_em->persist($_user);
        $this->_em->flush();
    }
}
