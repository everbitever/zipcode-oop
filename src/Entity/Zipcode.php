<?php

namespace App\Entity;

use App\Repository\ZipcodeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ZipcodeRepository::class)
 */
class Zipcode
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=6)
     */
    private $code;

    /**
     * @ORM\ManyToOne(targetEntity=Town::class, inversedBy="zipcodes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $town;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getTown(): ?Town
    {
        return $this->town;
    }

    public function setTown(?Town $town): self
    {
        $this->town = $town;

        return $this;
    }
}
