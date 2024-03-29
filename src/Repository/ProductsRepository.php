<?php

namespace App\Repository;

use App\Entity\Products;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Products>
 *
 * @method Products|null find($id, $lockMode = null, $lockVersion = null)
 * @method Products|null findOneBy(array $criteria, array $orderBy = null)
 * @method Products[]    findAll()
 * @method Products[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Products::class);
    }

    public function findProductsPaginated(int $page, int $limit = 10, ?int $gammeId = null): array {
        $limit = abs($limit);
        $result = [];
        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('p')
            ->from('App\Entity\Products', 'p')
            ->setMaxResults($limit)
            ->setFirstResult(($page * $limit) - $limit);
    
        if ($gammeId !== null && $gammeId !== 0) {
            $query->andWhere('p.gamme = :gammeId')
                ->setParameter('gammeId', $gammeId);
        }
    
        $paginator = new Paginator($query);
        $data = $paginator->getQuery()->getResult();
    
        if (empty($data)) {
            return $result;
        }
    
        $pages = ceil($paginator->count() / $limit);
        $result['data'] = $data;
        $result['pages'] = $pages;
        $result['page'] = $page;
        $result['limit'] = $limit;
    
        return $result;
    }

    public function findProductsByGammePaginated(?int $gammeId, int $page, int $limit = 10): array
    {
        $limit = abs($limit);
        $result = [];
        
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()
            ->select('p')
            ->from('App\Entity\Products', 'p')
            ->setMaxResults($limit)
            ->setFirstResult(($page * $limit) - $limit);
    
        if ($gammeId !== 0) {
            $queryBuilder->andWhere('p.gamme = :gammeId')
                         ->setParameter('gammeId', $gammeId);
        }
    
        $paginator = new Paginator($queryBuilder);
        $data = $paginator->getQuery()->getResult();
    
        if (empty($data)) {
            return $result;
        }
    
        $pages = ceil($paginator->count() / $limit);
        $result['data'] = $data;
        $result['pages'] = $pages;
        $result['page'] = $page;
        $result['limit'] = $limit;
    
        return $result;
    }

    //    /**
    //     * @return Products[] Returns an array of Products objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Products
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
