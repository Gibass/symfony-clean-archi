<?php

namespace App\Infrastructure\Doctrine\Factory;

use App\Infrastructure\Adapter\Repository\ArticleRepository;
use App\Infrastructure\Doctrine\Entity\ArticleDoctrine;
use Zenstruck\Foundry\LazyValue;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<ArticleDoctrine>
 *
 * @method        ArticleDoctrine|Proxy             create(array|callable $attributes = [])
 * @method static ArticleDoctrine|Proxy             createOne(array $attributes = [])
 * @method static ArticleDoctrine|Proxy             find(object|array|mixed $criteria)
 * @method static ArticleDoctrine|Proxy             findOrCreate(array $attributes)
 * @method static ArticleDoctrine|Proxy             first(string $sortedField = 'id')
 * @method static ArticleDoctrine|Proxy             last(string $sortedField = 'id')
 * @method static ArticleDoctrine|Proxy             random(array $attributes = [])
 * @method static ArticleDoctrine|Proxy             randomOrCreate(array $attributes = [])
 * @method static ArticleRepository|RepositoryProxy repository()
 * @method static ArticleDoctrine[]|Proxy[]         all()
 * @method static ArticleDoctrine[]|Proxy[]         createMany(int $number, array|callable $attributes = [])
 * @method static ArticleDoctrine[]|Proxy[]         createSequence(iterable|callable $sequence)
 * @method static ArticleDoctrine[]|Proxy[]         findBy(array $attributes)
 * @method static ArticleDoctrine[]|Proxy[]         randomRange(int $min, int $max, array $attributes = [])
 * @method static ArticleDoctrine[]|Proxy[]         randomSet(int $number, array $attributes = [])
 */
final class ArticleDoctrineFactory extends ModelFactory
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

    public function noTag(): self
    {
        return $this->addState(['tags' => []]);
    }

    public function published(): self
    {
        return $this->addState(['status' => true, 'publishedAt' => self::faker()->dateTime()]);
    }

    public function unpublished(): self
    {
        return $this->addState(['status' => false]);
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'status' => self::faker()->boolean(),
            'title' => self::faker()->sentence,
            'description' => self::faker()->paragraphs(3, true),
            'content' => self::faker()->paragraphs(20, true),
            'tags' => LazyValue::new(fn () => TagDoctrineFactory::randomRange(0, 5)),
            'createdAt' => self::faker()->dateTimeBetween('-1 year'),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this;
        // ->afterInstantiate(function(ArticleDoctrine $articleDoctrine): void {})
    }

    protected static function getClass(): string
    {
        return ArticleDoctrine::class;
    }
}
