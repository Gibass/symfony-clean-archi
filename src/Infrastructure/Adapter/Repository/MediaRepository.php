<?php

namespace App\Infrastructure\Adapter\Repository;

use App\Domain\Article\Entity\Media;
use App\Infrastructure\Doctrine\Entity\MediaDoctrine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MediaDoctrine>
 *
 * @method MediaDoctrine|null find($id, $lockMode = null, $lockVersion = null)
 * @method MediaDoctrine|null findOneBy(array $criteria, array $orderBy = null)
 * @method MediaDoctrine[]    findAll()
 * @method MediaDoctrine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MediaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MediaDoctrine::class);
    }

    public function convert(MediaDoctrine $mediaDoctrine): Media
    {
        return $this->_em->getRepository($mediaDoctrine::class)->convert($mediaDoctrine);
    }
}
