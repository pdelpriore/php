<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BillingRepository")
 * @UniqueEntity("alias", message="L'alias {{ value }} identifie déjà un autre type de facturation.")
 */
class Billing
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
     * @ORM\Column(type="string", length=5, unique=true)
     */
    private $alias;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Header", mappedBy="billing")
     */
    private $headers;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $billDefault;

    public function __construct()
    {
        $this->headers = new ArrayCollection();
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

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function setAlias(string $alias): self
    {
        $this->alias = strtoupper($alias);

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
            $header->setBilling($this);
        }

        return $this;
    }

    public function removeHeader(Header $header): self
    {
        if ($this->headers->contains($header)) {
            $this->headers->removeElement($header);
            // set the owning side to null (unless already changed)
            if ($header->getBilling() === $this) {
                $header->setBilling(null);
            }
        }

        return $this;
    }

    public function getBillDefault(): ?bool
    {
        return $this->billDefault;
    }

    public function setBillDefault(?bool $billDefault): self
    {
        $this->billDefault = $billDefault;

        return $this;
    }
}
