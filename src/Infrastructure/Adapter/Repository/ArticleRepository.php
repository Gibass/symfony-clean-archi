<?php

namespace App\Infrastructure\Adapter\Repository;

use App\Domain\Article\Entity\ArticleInterface;
use App\Domain\Article\Gateway\ArticleGatewayInterface;
use App\Domain\CRUD\Entity\CrudEntityInterface;
use App\Domain\CRUD\Entity\PostedData;
use App\Infrastructure\Doctrine\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Pagerfanta\Adapter\AdapterInterface;
use Pagerfanta\Doctrine\ORM\QueryAdapter;

/**
 * @extends ServiceEntityRepository<Article>
 *
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository implements ArticleGatewayInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function getByIdentifier(int|string $identifier): ?CrudEntityInterface
    {
        return $this->getById($identifier);
    }

    public function getPublishedById(int $id): ?ArticleInterface
    {
        return $this->getFullArticleQuery()
            ->andWhere('article.status = :status AND article.id = :articleId')
            ->setParameter('articleId', $id)
            ->setParameter('status', true)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function getById(int $id): ?ArticleInterface
    {
        return $this->findOneBy(['id' => $id]);
    }

    public function getFullArticleQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('article')
            ->addSelect('tags')
            ->addSelect('category')
            ->addSelect('owner')
            ->leftJoin('article.tags', 'tags')
            ->leftJoin('article.category', 'category')
            ->leftJoin('article.owner', 'owner')
        ;
    }

    public function orderQuery(): QueryBuilder
    {
        return $this->getFullArticleQuery()
            ->orderBy('article.createdAt', Criteria::DESC)
        ;
    }

    public function getPaginatedAdapter(array $conditions = []): AdapterInterface
    {
        $query = $this->orderQuery();

        if (empty($conditions['type']) || $conditions['type'] !== 'all') {
            $query = $query->andWhere('article.status = :status')
                ->setParameter('status', true)
            ;
        }

        return new QueryAdapter($query);
    }

    public function getLastArticles(): array
    {
        return $this->createQueryBuilder('article')
            ->where('article.status = :status')
            ->setParameter('status', true)
            ->orderBy('article.createdAt', Criteria::DESC)
            ->setMaxResults(3)
            ->getQuery()
            ->getResult()
        ;
    }

    public function create(PostedData $data): CrudEntityInterface
    {
        $article = $data->createEntity(Article::class);

        $this->_em->persist($article);
        $this->_em->flush();

        return $article;
    }

    public function update(PostedData $data): CrudEntityInterface
    {
        $article = $this->findOneBy(['id' => $data->get('id')]);

        $article = $data->updateEntity($article);

        $this->_em->flush();

        return $article;
    }

    public function delete(CrudEntityInterface $entity): bool
    {
        $this->_em->remove($entity);

        $this->_em->flush();

        return true;
    }
}
