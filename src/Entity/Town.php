<?php

namespace App\Entity;

use App\Repository\TownRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TownRepository::class)
 */
class Town
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Zipcode::class, mappedBy="town")
     */
    private $zipcodes;

    public function __construct()
    {
        $this->zipcodes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Zipcode>
     */
    public function getZipcodes(): Collection
    {
        return $this->zipcodes;
    }

    public function addZipcode(Zipcode $zipcode): self
    {
        if (!$this->zipcodes->contains($zipcode)) {
            $this->zipcodes[] = $zipcode;
            $zipcode->setTown($this);
        }

        return $this;
    }

    public function removeZipcode(Zipcode $zipcode): self
    {
        if ($this->zipcodes->removeElement($zipcode)) {
            // set the owning side to null (unless already changed)
            if ($zipcode->getTown() === $this) {
                $zipcode->setTown(null);
            }
        }

        return $this;
    }
}
