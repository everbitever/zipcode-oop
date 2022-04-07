<?php

namespace App\Component;

use App\Repository\TownRepository;

class ValidateTown
{
    private $townRepository;

    public function __construct(TownRepository $townRepository)
    {
        $this->townRepository = $townRepository;
    }

    public function validateDuplication(String $name)
    {
        return $this->townRepository->createQueryBuilder('t')
            ->select('count(t.id)')
            ->where('t.name = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getSingleScalarResult();
    }
}