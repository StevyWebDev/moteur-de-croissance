<?php

namespace App\Repository;

use App\Entity\Company;
use App\Entity\CompanyNotice;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method CompanyNotice|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompanyNotice|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompanyNotice[]    findAll()
 * @method CompanyNotice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyNoticeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompanyNotice::class);
    }

    // /**
    //  * @return CompanyNotice[] Returns an array of CompanyNotice objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CompanyNotice
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function averageStar(Company $company) {
        $query = $this->createQueryBuilder('c')
            ->select('AVG(c.star) as average')
            ->addSelect('COUNT(c.star) as counter')
            ->andWhere('c.company = :company')
            ->setParameter('company', $company)
            ->getQuery()
        ;

        return $query->getResult();
    }
}
