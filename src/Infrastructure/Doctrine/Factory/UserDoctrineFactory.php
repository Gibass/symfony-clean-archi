<?php

namespace App\Infrastructure\Doctrine\Factory;

use App\Infrastructure\Adapter\Repository\UserRepository;
use App\Infrastructure\Doctrine\Entity\UserDoctrine;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<UserDoctrine>
 *
 * @method        UserDoctrine|Proxy             create(array|callable $attributes = [])
 * @method static UserDoctrine|Proxy             createOne(array $attributes = [])
 * @method static UserDoctrine|Proxy             find(object|array|mixed $criteria)
 * @method static UserDoctrine|Proxy             findOrCreate(array $attributes)
 * @method static UserDoctrine|Proxy             first(string $sortedField = 'id')
 * @method static UserDoctrine|Proxy             last(string $sortedField = 'id')
 * @method static UserDoctrine|Proxy             random(array $attributes = [])
 * @method static UserDoctrine|Proxy             randomOrCreate(array $attributes = [])
 * @method static UserRepository|RepositoryProxy repository()
 * @method static UserDoctrine[]|Proxy[]         all()
 * @method static UserDoctrine[]|Proxy[]         createMany(int $number, array|callable $attributes = [])
 * @method static UserDoctrine[]|Proxy[]         createSequence(iterable|callable $sequence)
 * @method static UserDoctrine[]|Proxy[]         findBy(array $attributes)
 * @method static UserDoctrine[]|Proxy[]         randomRange(int $min, int $max, array $attributes = [])
 * @method static UserDoctrine[]|Proxy[]         randomSet(int $number, array $attributes = [])
 */
final class UserDoctrineFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'email' => self::faker()->email,
            'firstname' => self::faker()->firstName,
            'lastname' => self::faker()->lastName,
            'plainPassword' => self::faker()->password(),
            'roles' => [],
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this;
        // ->afterInstantiate(function(UserDoctrine $userDoctrine): void {})
    }

    protected static function getClass(): string
    {
        return UserDoctrine::class;
    }
}
