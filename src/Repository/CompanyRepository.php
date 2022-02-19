<?php

namespace App\Repository;

use App\Entity\Company;
use App\Entity\CompanySearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Company|null find($id, $lockMode = null, $lockVersion = null)
 * @method Company|null findOneBy(array $criteria, array $orderBy = null)
 * @method Company[]    findAll()
 * @method Company[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Company::class);
    }

    // /**
    //  * @return Company[] Returns an array of Company objects
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

    public function search(CompanySearch $search) {
        $query = $this
            ->createQueryBuilder('company')
            ->select('company')
            ->leftJoin('company.companyActivities', 'activity')
            ->addSelect('activity');

        if($search->getLat() && $search->getLng() && $search->getDistance()) {
            
            $query = $query
                ->andWhere('(6353 * 2 * ASIN(SQRT( POWER(SIN((company.lat - :lat) *  pi()/180 / 2), 2) +COS(company.lat * pi()/180) * COS(:lat * pi()/180) * POWER(SIN((company.lng - :lng) * pi()/180 / 2), 2) ))) <= :distance')
                ->setParameter('lng', $search->getLng())
                ->setParameter('lat', $search->getLat())
                ->setParameter('distance', $search->getDistance());
            ;
        }

        if($search->getNameActivity()) {
            $query = $query
                ->andWhere($query->expr()->in('activity', ":activity"))
                ->setParameter('activity', $search->getNameActivity())
            ;
        }

        return $query->getQuery()
                    ->getResult();
    }

    public function findCompanyBySearch($values)
    {
        if($values[0] !== "") {
            $query = $this->createQueryBuilder('c')
                        ->select('c');
            foreach($values as $k => $value) {
                $query = $query
                    ->orWhere("c.name LIKE :val$k")
                    ->setParameter("val$k", "%".$value."%")
                ;
            }

            return $query->getQuery()
                    ->getResult();
        }
    }

    public function findByUnderActivity($underActivities) {
        $error = true;
        $query = $this->createQueryBuilder('a')
                    ->select('a')
                    ->leftJoin('a.underActivities', 'c')
                    ->addSelect('c')
        ;

        if(isset($underActivities[0])) {
            $error = false;

            foreach($underActivities as $k => $value) {
                $query = $query->andWhere($query->expr()->in('c', ":val"))
                            ->setParameter("val", $value)
                ;
            }
        }

        if($error !== true) {
            $error = false;
            return $query->getQuery()
                    ->getResult();
        }
    }

/* public function findBySearch($companies, $activities, $underActivities=null) {
    $error = true;
        $query = $this->createQueryBuilder('a')
                  ->select('a')
                  ->leftJoin('a.underActivities', 'c')
                  ->addSelect('c')
                  ->leftJoin('a.companyActivities', 'd')
                  ->addSelect('d');
        if(isset($companies[0])){
            $error = false;
            foreach($companies as $k => $value) {
                $query = $query->orWhere("a.id = :val$k")
                        ->setParameter("val$k", $value['id'])
                ;
            }
        }

        if(isset($activities[0])){
            $error = false;
            foreach($activities as $k => $value) {
                $query = $query->orWhere($query->expr()->in('d', ":val$k"))
                        ->setParameter("val$k", $value['id'])
                ;
            }
        }
        foreach($values as $k => $value) {
            $query = $query->orWhere($query->expr()->in('c', ":val$k"))
                    ->orWhere($query->expr()->in('d', ":val$k"))
                    ->setParameter("val$k", $value)
            ;
        }
        
        if($error !== true) {
            $error = false;
            return $query->getQuery()
                    ->getResult();
        }
    } */

    /*
    public function findOneBySomeField($value): ?Company
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
