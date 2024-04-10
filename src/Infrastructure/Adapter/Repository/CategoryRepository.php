<?php

namespace App\Infrastructure\Adapter\Repository;

use App\Domain\Article\Entity\TaxonomyInterface;
use App\Domain\Category\Gateway\CategoryGatewayInterface;
use App\Domain\CRUD\Entity\CrudEntityInterface;
use App\Infrastructure\Adapter\Repository\Trait\CrudRepository;
use App\Infrastructure\Doctrine\Entity\Article;
use App\Infrastructure\Doctrine\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ManagerRegistry;
use Pagerfanta\Adapter\AdapterInterface;
use Pagerfanta\Doctrine\ORM\QueryAdapter;

/**
 * @extends ServiceEntityRepository<Category>
 *
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository implements CategoryGatewayInterface
{
    use CrudRepository;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function getById(int $id): ?TaxonomyInterface
    {
        return $this->findOneBy(['id' => $id]);
    }

    public function getBySlug(string $slug): ?TaxonomyInterface
    {
        return $this->findOneBy(['slug' => $slug]);
    }

    public function getArticlePaginated(int $id): AdapterInterface
    {
        $query = $this->_em->getRepository(Article::class)->orderQuery()
            ->andwhere('category.id = :categoryId AND article.status = :status')
            ->setParameter('categoryId', $id)
            ->setParameter('status', true)
        ;

        return new QueryAdapter($query);
    }

    public function getFacetCategories(): array
    {
        return $this->createQueryBuilder('cat')
            ->select('cat.slug, cat.title, COUNT(articles) AS total')
            ->leftJoin('cat.articles', 'articles')
            ->andWhere('articles.status = :status')
            ->having('total > 0')
            ->groupBy('cat.slug')
            ->orderBy('total', Criteria::DESC)
            ->setParameter('status', true)
            ->setMaxResults(5)
            ->getQuery()
            ->getScalarResult()
        ;
    }

    public function getAll(): array
    {
        return $this->findAll();
    }

    public function getByIdentifier(int|string $identifier): ?CrudEntityInterface
    {
        if (\is_int($identifier)) {
            return $this->getById($identifier);
        }

        return $this->getBySlug($identifier);
    }

    public function getPaginatedAdapter(array $conditions = []): AdapterInterface
    {
        $query = $this->createQueryBuilder('cat')
            ->orderBy('cat.title', 'ASC')
        ;

        return new QueryAdapter($query);
    }
}
