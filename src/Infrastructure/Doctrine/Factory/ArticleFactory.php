<?php

namespace App\Infrastructure\Doctrine\Factory;

use App\Infrastructure\Adapter\Repository\ArticleRepository;
use App\Infrastructure\Doctrine\Entity\Article;
use Zenstruck\Foundry\LazyValue;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Article>
 *
 * @method        Article|Proxy                     create(array|callable $attributes = [])
 * @method static Article|Proxy                     createOne(array $attributes = [])
 * @method static Article|Proxy                     find(object|array|mixed $criteria)
 * @method static Article|Proxy                     findOrCreate(array $attributes)
 * @method static Article|Proxy                     first(string $sortedField = 'id')
 * @method static Article|Proxy                     last(string $sortedField = 'id')
 * @method static Article|Proxy                     random(array $attributes = [])
 * @method static Article|Proxy                     randomOrCreate(array $attributes = [])
 * @method static ArticleRepository|RepositoryProxy repository()
 * @method static Article[]|Proxy[]                 all()
 * @method static Article[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Article[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Article[]|Proxy[]                 findBy(array $attributes)
 * @method static Article[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Article[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class ArticleFactory extends ModelFactory
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

    public function noTaxonomy(): self
    {
        return $this->addState(['tags' => [], 'category' => null]);
    }

    public function noCategory(): self
    {
        return $this->addState(['category' => null]);
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
            'category' => LazyValue::new(fn () => CategoryFactory::random()),
            'tags' => LazyValue::new(fn () => TagFactory::randomRange(0, 5)),
            'createdAt' => self::faker()->dateTimeBetween('-1 year'),
            'owner' => LazyValue::new(fn () => UserFactory::random()),
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
        return Article::class;
    }
}
