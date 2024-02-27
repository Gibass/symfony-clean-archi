<?php

namespace App\Infrastructure\Adapter\Repository;

use App\Domain\Article\Entity\Category;
use App\Domain\Category\Gateway\CategoryGatewayInterface;
use App\Infrastructure\Doctrine\Entity\ArticleDoctrine;
use App\Infrastructure\Doctrine\Entity\CategoryDoctrine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Pagerfanta\Adapter\AdapterInterface;
use Pagerfanta\Doctrine\ORM\QueryAdapter;

/**
 * @extends ServiceEntityRepository<CategoryDoctrine>
 *
 * @method CategoryDoctrine|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryDoctrine|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryDoctrine[]    findAll()
 * @method CategoryDoctrine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository implements CategoryGatewayInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryDoctrine::class);
    }

    public function getBySlug(string $slug): ?Category
    {
        $_category = $this->findOneBy(['slug' => $slug]);

        return $_category ? $this->convert($_category) : null;
    }

    public function getPaginatedAdapter(array $conditions = []): AdapterInterface
    {
        $query = $this->_em->getRepository(ArticleDoctrine::class)->orderQuery()
            ->andwhere('category.id = :categoryId AND article.status = :status')
            ->setParameter('categoryId', $conditions['id'] ?? null)
        ;

        return new QueryAdapter($query);
    }

    public function getFacetCategories(): array
    {
        return [];
    }

    public function convert(CategoryDoctrine $category): Category
    {
        return (new Category($category->getTitle(), $category->getSlug()))
            ->setId($category->getId())
        ;
    }
}
