<?php

namespace App\Infrastructure\Adapter\Repository;

use App\Domain\CRUD\Entity\CrudEntityInterface;
use App\Domain\Security\Entity\UserEntityInterface;
use App\Domain\Security\Gateway\UserGatewayInterface;
use App\Infrastructure\Adapter\Repository\Trait\CrudRepository;
use App\Infrastructure\Doctrine\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Pagerfanta\Adapter\AdapterInterface;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @implements PasswordUpgraderInterface<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface, UserGatewayInterface
{
    use CrudRepository;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function findByEmail(string $email): ?UserEntityInterface
    {
        return $this->findOneBy(['email' => $email]);
    }

    public function register(array $data): UserEntityInterface
    {
        $user = (new User())
            ->setEmail($data['email'] ?? null)
            ->setPlainPassword($data['password'] ?? null)
        ;

        $this->_em->persist($user);
        $this->_em->flush();

        return $user;
    }

    public function validate(UserEntityInterface $user): void
    {
        $user = $this->findOneBy(['email' => $user->getEmail()]);

        if ($user) {
            $user->setIsVerified(true);
            $this->_em->flush();
        }
    }

    public function getByIdentifier(int|string $identifier): ?CrudEntityInterface
    {
        return $this->findOneBy(['id' => $identifier]);
    }

    public function getPaginatedAdapter(array $conditions = []): AdapterInterface
    {
        $query = $this->createQueryBuilder('user')
            ->orderBy('user.id', 'DESC')
        ;

        return new QueryAdapter($query);
    }
}
