<?php

namespace App\Infrastructure\Adapter\Repository;

use App\Domain\Article\Entity\Article;
use App\Domain\Article\Gateway\ArticleGatewayInterface;
use App\Infrastructure\Doctrine\Entity\ArticleDoctrine;
use App\Infrastructure\Doctrine\Entity\MediaDoctrine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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

    public function getById(int $id): ?Article
    {
        $_article = $this->find($id);

        return $_article ? $this->convert($_article) : null;
    }

    public function getPublishedById(int $id): ?Article
    {
        $_article = $this->findOneBy([
            'id' => $id,
            'status' => true,
        ]);

        return $_article ? $this->convert($_article) : null;
    }

    private function convert(ArticleDoctrine $articleDoctrine): Article
    {
        return (new Article())
            ->setId($articleDoctrine->getId())
            ->setSlug($articleDoctrine->getSlug())
            ->setTitle($articleDoctrine->getTitle())
            ->setMainMedia(
                $articleDoctrine->getMainMedia() ?
                    $this->_em->getRepository(MediaDoctrine::class)->convert($articleDoctrine->getMainMedia()) :
                    null
            )
            ->setContent($articleDoctrine->getContent())
            ->setStatus($articleDoctrine->isPublished())
            ->setUpdatedAt($articleDoctrine->getUpdatedAt())
            ->setCreatedAt($articleDoctrine->getCreatedAt())
            ->setPublishedAt($articleDoctrine->getPublishedAt())
        ;
    }

    public function getPaginatedAdapter(): AdapterInterface
    {
        $queryBuilder = $this->createQueryBuilder('a')
            ->where('a.status = :status')
            ->orderBy('a.createdAt', 'DESC')
            ->setParameter('status', true);

        return new QueryAdapter($queryBuilder);
    }
}
