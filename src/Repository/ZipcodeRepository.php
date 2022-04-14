<?php

namespace App\Repository;

use App\Entity\Zipcode;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
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

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Zipcode::class);

        $this->entityManager = $entityManager;
    }

    public function getTownWithCode(String $search)
    {
        $where = '';

        if(!empty($search)) $where = 'AND z.code = \''.$search.'\'';

        $sql = '
            SELECT z.id, z.code, t.name
            FROM App\Entity\Zipcode z INNER JOIN App\Entity\Town t WITH z.town = t.id
            WHERE 1=1 '.$where.'
            ORDER BY t.name ASC, z.code ASC
        ';

        return $this->entityManager->createQuery($sql)->getResult();
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
