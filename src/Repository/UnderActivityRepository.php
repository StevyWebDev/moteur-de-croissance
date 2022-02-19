<?php

namespace App\Repository;

use App\Entity\UnderActivity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UnderActivity|null find($id, $lockMode = null, $lockVersion = null)
 * @method UnderActivity|null findOneBy(array $criteria, array $orderBy = null)
 * @method UnderActivity[]    findAll()
 * @method UnderActivity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UnderActivityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UnderActivity::class);
    }

    // /**
    //  * @return UnderActivity[] Returns an array of UnderActivity objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    public function findUnderActivityBySearch($values)
    {
        if($values[0] !== "") {
            $query = $this->createQueryBuilder('c');
            foreach($values as $k => $value) {
                $query = $query
                    ->andWhere("c.name LIKE :val$k")
                    ->setParameter("val$k", "%".$value."%")
                ;
            }

            return $query->getQuery()
                    ->getResult();
        }
    }

    /*
    public function findOneBySomeField($value): ?UnderActivity
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
