<?php

namespace App\Infrastructure\Doctrine\Factory;

use App\Infrastructure\Adapter\Repository\TagRepository;
use App\Infrastructure\Doctrine\Entity\TagDoctrine;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<TagDoctrine>
 *
 * @method        TagDoctrine|Proxy             create(array|callable $attributes = [])
 * @method static TagDoctrine|Proxy             createOne(array $attributes = [])
 * @method static TagDoctrine|Proxy             find(object|array|mixed $criteria)
 * @method static TagDoctrine|Proxy             findOrCreate(array $attributes)
 * @method static TagDoctrine|Proxy             first(string $sortedField = 'id')
 * @method static TagDoctrine|Proxy             last(string $sortedField = 'id')
 * @method static TagDoctrine|Proxy             random(array $attributes = [])
 * @method static TagDoctrine|Proxy             randomOrCreate(array $attributes = [])
 * @method static TagRepository|RepositoryProxy repository()
 * @method static TagDoctrine[]|Proxy[]         all()
 * @method static TagDoctrine[]|Proxy[]         createMany(int $number, array|callable $attributes = [])
 * @method static TagDoctrine[]|Proxy[]         createSequence(iterable|callable $sequence)
 * @method static TagDoctrine[]|Proxy[]         findBy(array $attributes)
 * @method static TagDoctrine[]|Proxy[]         randomRange(int $min, int $max, array $attributes = [])
 * @method static TagDoctrine[]|Proxy[]         randomSet(int $number, array $attributes = [])
 */
final class TagDoctrineFactory extends ModelFactory
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
            'title' => ucwords(self::faker()->words(self::faker()->numberBetween(1, 2), true)),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this;
        // ->afterInstantiate(function(TagDoctrine $tagDoctrine): void {})
    }

    protected static function getClass(): string
    {
        return TagDoctrine::class;
    }
}
