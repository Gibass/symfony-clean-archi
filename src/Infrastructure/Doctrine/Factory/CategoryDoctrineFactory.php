<?php

namespace App\Infrastructure\Doctrine\Factory;

use App\Infrastructure\Adapter\Repository\CategoryRepository;
use App\Infrastructure\Doctrine\Entity\CategoryDoctrine;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<CategoryDoctrine>
 *
 * @method        CategoryDoctrine|Proxy             create(array|callable $attributes = [])
 * @method static CategoryDoctrine|Proxy             createOne(array $attributes = [])
 * @method static CategoryDoctrine|Proxy             find(object|array|mixed $criteria)
 * @method static CategoryDoctrine|Proxy             findOrCreate(array $attributes)
 * @method static CategoryDoctrine|Proxy             first(string $sortedField = 'id')
 * @method static CategoryDoctrine|Proxy             last(string $sortedField = 'id')
 * @method static CategoryDoctrine|Proxy             random(array $attributes = [])
 * @method static CategoryDoctrine|Proxy             randomOrCreate(array $attributes = [])
 * @method static CategoryRepository|RepositoryProxy repository()
 * @method static CategoryDoctrine[]|Proxy[]         all()
 * @method static CategoryDoctrine[]|Proxy[]         createMany(int $number, array|callable $attributes = [])
 * @method static CategoryDoctrine[]|Proxy[]         createSequence(iterable|callable $sequence)
 * @method static CategoryDoctrine[]|Proxy[]         findBy(array $attributes)
 * @method static CategoryDoctrine[]|Proxy[]         randomRange(int $min, int $max, array $attributes = [])
 * @method static CategoryDoctrine[]|Proxy[]         randomSet(int $number, array $attributes = [])
 */
final class CategoryDoctrineFactory extends ModelFactory
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
            'title' => ucwords(self::faker()->word),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this;
        // ->afterInstantiate(function(CategoryDoctrine $categoryDoctrine): void {})
    }

    protected static function getClass(): string
    {
        return CategoryDoctrine::class;
    }
}
