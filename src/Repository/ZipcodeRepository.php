<?php

namespace App\Repository;

use App\Entity\Zipcode;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Zipcode|null find($id, $lockMode = null, $lockVersion = null)
 * @method Zipcode|null findOneBy(array $criteria, array $orderBy = null)
 * @method Zipcode[]    findAll()
 * @method Zipcode[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ZipcodeRepository extends ServiceEntityRepository
{
    private $entityManagerInterface;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Zipcode::class);
    }

    public function getTownWithCode(String $search)
    {
        $query = $this->createQueryBuilder('z');
        $query->select('z.id, z.code, t.name');
        $query->innerJoin('z.town', 't');
        if(!empty($search))
        {
            $query->where('z.code = :search');
            $query->setParameter('search', $search);
        }
        $query->orderBy('t.name', 'ASC');
        $query->addOrderBy('z.code', 'ASC');
        $query->getQuery()->execute();

        return $query;
    }

    public function deleteAllCodeWithTown(int $town)
    {
        return $this->createQueryBuilder('z')
            ->delete()
            ->where('z.town = :town')
            ->setParameter('town', $town)
            ->getQuery()
            ->execute();
    }

    // /**
    //  * @return Zipcode[] Returns an array of Zipcode objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('z')
            ->andWhere('z.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('z.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Zipcode
    {
        return $this->createQueryBuilder('z')
            ->andWhere('z.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
