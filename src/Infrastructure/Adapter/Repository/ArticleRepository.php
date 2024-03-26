<?php

namespace App\Infrastructure\Adapter\Repository;

use App\Domain\Article\Entity\Article;
use App\Domain\Article\Gateway\ArticleGatewayInterface;
use App\Domain\CRUD\Entity\CrudEntityInterface;
use App\Domain\CRUD\Entity\PostedData;
use App\Infrastructure\Doctrine\Entity\ArticleDoctrine;
use App\Infrastructure\Doctrine\Entity\CategoryDoctrine;
use App\Infrastructure\Doctrine\Entity\TagDoctrine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Pagerfanta\Adapter\AdapterInterface;
use Pagerfanta\Doctrine\ORM\QueryAdapter;

/**
 * @extends ServiceEntityRepository<ArticleDoctrine>
 *
 * @method ArticleDoctrine|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArticleDoctrine|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArticleDoctrine[]    findAll()
 * @method ArticleDoctrine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository implements ArticleGatewayInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArticleDoctrine::class);
    }

    public function getPublishedById(int $id): ?Article
    {
        $_article = $this->getFullArticleQuery()
            ->andWhere('article.status = :status AND article.id = :articleId')
            ->setParameter('articleId', $id)
            ->setParameter('status', true)
            ->getQuery()
            ->getOneOrNullResult()
        ;

        return $_article ? $this->convert($_article) : null;
    }

    public function getFullArticleQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('article')
            ->addSelect('tags')
            ->addSelect('category')
            ->leftJoin('article.tags', 'tags')
            ->leftJoin('article.category', 'category')
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
        /** @var ArticleDoctrine $article */
        $article = $data->createEntity(ArticleDoctrine::class);

        $this->_em->persist($article);
        $this->_em->flush();

        return $this->convert($article);
    }

    public function convert(ArticleDoctrine $articleDoctrine): Article
    {
        return (new Article())
            ->setId($articleDoctrine->getId())
            ->setSlug($articleDoctrine->getSlug())
            ->setTitle($articleDoctrine->getTitle())
            ->addTags(
                $articleDoctrine->getTags() ? array_map(function (TagDoctrine $tag) {
                    return $this->_em->getRepository(TagDoctrine::class)->convert($tag);
                }, $articleDoctrine->getTags()->toArray()) : []
            )
            ->setDescription($articleDoctrine->getDescription())
            ->setContent($articleDoctrine->getContent())
            ->setCategory(
                $articleDoctrine->getCategory() ?
                    $this->_em->getRepository(CategoryDoctrine::class)->convert($articleDoctrine->getCategory()) :
                    null
            )
            ->setStatus($articleDoctrine->isPublished())
            ->setUpdatedAt($articleDoctrine->getUpdatedAt())
            ->setCreatedAt($articleDoctrine->getCreatedAt())
            ->setPublishedAt($articleDoctrine->getPublishedAt())
        ;
    }
}
