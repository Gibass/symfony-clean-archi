<?php

namespace App\Infrastructure\Adapter\Repository;

use App\Domain\Article\Entity\Tag;
use App\Domain\Tag\Gateway\TagGatewayInterface;
use App\Infrastructure\Doctrine\Entity\ArticleDoctrine;
use App\Infrastructure\Doctrine\Entity\TagDoctrine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ManagerRegistry;
use Pagerfanta\Adapter\AdapterInterface;
use Pagerfanta\Doctrine\ORM\QueryAdapter;

/**
 * @extends ServiceEntityRepository<TagDoctrine>
 *
 * @method TagDoctrine|null find($id, $lockMode = null, $lockVersion = null)
 * @method TagDoctrine|null findOneBy(array $criteria, array $orderBy = null)
 * @method TagDoctrine[]    findAll()
 * @method TagDoctrine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TagRepository extends ServiceEntityRepository implements TagGatewayInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TagDoctrine::class);
    }

    public function getBySlug(string $slug): ?Tag
    {
        $_tag = $this->findOneBy(['slug' => $slug]);

        return $_tag ? $this->convert($_tag) : null;
    }

    public function getPaginatedAdapter(Tag $tag): AdapterInterface
    {
        $query = $this->_em->getRepository(ArticleDoctrine::class)->createQueryBuilder('article')
            ->addSelect('tags')
            ->leftJoin('article.tags', 'tags')
            ->andwhere('tags.id = :tagId AND article.status = :status')
            ->orderBy('article.createdAt', Criteria::DESC)
            ->setParameter('tagId', $tag->getId())
            ->setParameter('status', true)
        ;

        return new QueryAdapter($query);
    }

    public function convert(TagDoctrine $tagDoctrine): Tag
    {
        return (new Tag($tagDoctrine->getTitle(), $tagDoctrine->getSlug()))
            ->setId($tagDoctrine->getId())
        ;
    }

    //    /**
    //     * @return TagDoctrine[] Returns an array of TagDoctrine objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?TagDoctrine
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
