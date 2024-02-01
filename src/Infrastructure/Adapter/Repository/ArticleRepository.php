<?php

namespace App\Infrastructure\Adapter\Repository;

use App\Domain\Article\Entity\Article;
use App\Domain\Article\Gateway\ArticleGatewayInterface;
use App\Infrastructure\Doctrine\Entity\ArticleDoctrine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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

    private function convert(ArticleDoctrine $articleDoctrine): Article
    {
        return (new Article())
            ->setId($articleDoctrine->getId())
            ->setTitle($articleDoctrine->getTitle())
            ->setContent($articleDoctrine->getContent())
        ;
    }
}
