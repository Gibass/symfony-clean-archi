<?php

namespace App\Infrastructure\Adapter\Repository;

use App\Domain\Article\Entity\Image;
use App\Infrastructure\Doctrine\Entity\ImageDoctrine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ImageDoctrine>
 *
 * @method ImageDoctrine|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImageDoctrine|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImageDoctrine[]    findAll()
 * @method ImageDoctrine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImageDoctrine::class);
    }

    public function convert(ImageDoctrine $imageDoctrine): Image
    {
        return (new Image())
            ->setId($imageDoctrine->getId())
            ->setTitle($imageDoctrine->getTitle())
            ->setPath($imageDoctrine->getPath())
            ->setCreatedAt($imageDoctrine->getCreatedAt())
            ->setUpdatedAt($imageDoctrine->getUpdatedAt())
        ;
    }
}
