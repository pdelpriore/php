<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ApplicationRepository")
 * @UniqueEntity("alias", message="L'alias {{ value }} identifie déjà une autre application.")
 */
class Application
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
     * @ORM\Column(type="integer", nullable=true)
     */
    private $RD_ref;

    /**
     * @ORM\Column(type="string", length=10, unique=true)
     */
    private $alias;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="applications")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Header", mappedBy="application")
     */
    private $headers;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\InChargePerson", mappedBy="applications")
     * @ORM\OrderBy({"lastName" = "ASC"})
     */
    private $inChargePeople;

    public function __construct()
    {
        $this->headers = new ArrayCollection();
        $this->inChargePeople = new ArrayCollection();
    }

    public function getId()
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

    public function getRDRef(): ?int
    {
        return $this->RD_ref;
    }

    public function setRDRef(int $RD_ref): self
    {
        $this->RD_ref = $RD_ref;

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

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Collection|Header[]
     */
    public function getHeaders(): Collection
    {
        return $this->headers;
    }

    public function addHeader(Header $header): self
    {
        if (!$this->headers->contains($header)) {
            $this->headers[] = $header;
            $header->setApplication($this);
        }

        return $this;
    }

    public function removeHeader(Header $header): self
    {
        if ($this->headers->contains($header)) {
            $this->headers->removeElement($header);
            // set the owning side to null (unless already changed)
            if ($header->getApplication() === $this) {
                $header->setApplication(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|InChargePerson[]
     */
    public function getInChargePeople(): Collection
    {
        return $this->inChargePeople;
    }

    public function addInChargePerson(InChargePerson $inChargePerson): self
    {
        if (!$this->inChargePeople->contains($inChargePerson)) {
            $this->inChargePeople[] = $inChargePerson;
            $inChargePerson->addApplication($this);
        }

        return $this;
    }

    public function removeInChargePerson(InChargePerson $inChargePerson): self
    {
        if ($this->inChargePeople->contains($inChargePerson)) {
            $this->inChargePeople->removeElement($inChargePerson);
            $inChargePerson->removeApplication($this);
        }

        return $this;
    }
    public function removeEachInChargePerson(): self
    {
        foreach ($this->inChargePeople as $inChargePerson) {
            $this->inChargePeople->removeElement($inChargePerson);
            $inChargePerson->removeApplication($this);
        }

        return $this;
    }
}
