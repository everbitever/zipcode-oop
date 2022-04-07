<?php

namespace App\Component;

use Doctrine\ORM\EntityManagerInterface;

class ValidateZipcode
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function validateCode(String $code)
    {
        return preg_match('/^[0-9]{2}\-[0-9]{3}$/', $code);
    }

    public function validateCodeTown(String $code, String $town)
    {
        $sql = '
            SELECT z.id
            FROM App\Entity\Zipcode z INNER JOIN App\Entity\Town t WITH z.town = t.id
            WHERE z.code = :code AND t.name = :name
        ';

        $unique = $this->entityManager->createQuery($sql)
            ->setParameter('code', $code)
            ->setParameter('name', $town)
            ->getResult();

        return count($unique);
    }
}