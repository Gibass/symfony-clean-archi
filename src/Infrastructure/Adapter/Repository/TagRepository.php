<?php

namespace App\Infrastructure\Adapter\Repository;

use App\Domain\Article\Entity\TaxonomyInterface;
use App\Domain\CRUD\Entity\CrudEntityInterface;
use App\Domain\Tag\Gateway\TagGatewayInterface;
use App\Infrastructure\Adapter\Repository\Trait\CrudRepository;
use App\Infrastructure\Doctrine\Entity\Article;
use App\Infrastructure\Doctrine\Entity\Tag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Pagerfanta\Adapter\AdapterInterface;
use Pagerfanta\Doctrine\ORM\QueryAdapter;

/**
 * @extends ServiceEntityRepository<Tag>
 *
 * @method Tag|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tag|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tag[]    findAll()
 * @method Tag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TagRepository extends ServiceEntityRepository implements TagGatewayInterface
{
    use CrudRepository;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tag::class);
    }

    public function getByIds(array $ids): array
    {
        return $this->findBy(['id' => $ids]);
    }

    public function getAll(): array
    {
        return $this->findAll();
    }

    public function getBySlug(string $slug): ?TaxonomyInterface
    {
        return $this->findOneBy(['slug' => $slug]);
    }

    public function getArticlePaginated(int $id): AdapterInterface
    {
        $query = $this->_em->getRepository(Article::class)->orderQuery()
            ->andwhere('tags.id = :tagId AND article.status = :status')
            ->setParameter('tagId', $id)
            ->setParameter('status', true)
        ;

        return new QueryAdapter($query);
    }

    public function getPaginatedAdapter(array $conditions = []): AdapterInterface
    {
        $query = $this->createQueryBuilder('tag')
            ->orderBy('tag.title', 'ASC')
        ;

        return new QueryAdapter($query);
    }

    public function getPopularTag(): array
    {
        return $this->createQueryBuilder('tag')
            ->select('tag')
            ->leftJoin('tag.articles', 'articles')
            ->where('articles.status = :status')
            ->setParameter(':status', true)
            ->groupBy('tag.id')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
        ;
    }

    public function getByIdentifier(int|string $identifier): ?CrudEntityInterface
    {
        if (\is_int($identifier)) {
            return $this->getById($identifier);
        }

        return $this->getBySlug($identifier);
    }

    public function getById(int $id): ?TaxonomyInterface
    {
        return $this->findOneBy(['id' => $id]);
    }
}
