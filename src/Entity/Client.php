<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 * @UniqueEntity("alias", message="L'alias {{ value }} identifie déjà un autre client.")
 */
class Client
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=10, unique=true)
     */
    private $alias;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $dayly_cost;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $logo;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Application", mappedBy="client", cascade={"persist"})
     * @ORM\OrderBy({"name" = "ASC"})
     * @Assert\Valid()
     */
    private $applications;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\InChargePerson", mappedBy="client", cascade={"persist"})
     * @ORM\OrderBy({"lastName" = "ASC"})
     */
    private $inChargePersons;

    public function __construct()
    {
        $this->applications = new ArrayCollection();
        $this->inChargePersons = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = strtoupper($name);

        return $this;
    }

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function setAlias(string $alias): self
    {
        $this->alias = strtoupper($alias);

        return $this;
    }

    public function getDaylyCost(): ?float
    {
        return $this->dayly_cost;
    }

    public function setDaylyCost(?float $dayly_cost): self
    {
        $this->dayly_cost = $dayly_cost;

        return $this;
    }

    public function getLogo()
    {
        return $this->logo;
    }

    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * @return Collection|Application[]
     */
    public function getApplications(): Collection
    {
        return $this->applications;
    }

    public function addApplication(Application $application): self
    {
        if (!$this->applications->contains($application)) {
            $this->applications[] = $application;
            $application->setClient($this);
        }

        return $this;
    }

    public function removeApplication(Application $application): self
    {
        if ($this->applications->contains($application)) {
            $this->applications->removeElement($application);
            // set the owning side to null (unless already changed)
            if ($application->getClient() === $this) {
                $application->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|InChargePerson[]
     */
    public function getInChargePersons(): Collection
    {
        return $this->inChargePersons;
    }

    public function addInChargePerson(InChargePerson $inChargePerson): self
    {
        if (!$this->inChargePersons->contains($inChargePerson)) {
            $this->inChargePersons[] = $inChargePerson;
            $inChargePerson->setClient($this);
        }

        return $this;
    }

    public function removeInChargePerson(InChargePerson $inChargePerson): self
    {
        if ($this->inChargePersons->contains($inChargePerson)) {
            $this->inChargePersons->removeElement($inChargePerson);
            // set the owning side to null (unless already changed)
            if ($inChargePerson->getClient() === $this) {
                $inChargePerson->setClient(null);
            }
        }

        return $this;
    }
}
