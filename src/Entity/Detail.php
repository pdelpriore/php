<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OrderBy;


/**
 * @ORM\Entity(repositoryClass="App\Repository\DetailRepository")
 */
class Detail
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="float", precision=10, scale=2, nullable=true)
     */
    private $estimated_days;

    /**
     * @ORM\Column(type="float", precision=10, scale=2)
     */
    private $calculated_days;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Header", inversedBy="details")
     * @ORM\JoinColumn(nullable=false)
     */
    private $header;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ActivityGroup", inversedBy="details")
     * @ORM\JoinColumn(nullable=false)
     */
    private $activityGroup;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Profil", inversedBy="details")
     * @ORM\JoinColumn(nullable=true)
     */
    private $profil;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CertaintyLevel", inversedBy="details")
     * @ORM\JoinColumn(nullable=true)
     */
    private $certaintyLevel;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $rd_number;

    /**
     * @ORM\Column(type="float")
     */
    private $low_days;

    /**
     * @ORM\Column(type="float")
     */
    private $high_days;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_on;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_on;

    /**
     * @ORM\Column(type="boolean")
     */
    private $automatic;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $dailyCost;

    public function __construct()
    {
        $this->setCreatedOn(new \DateTime());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getEstimatedDays(): ?float
    {
        return $this->estimated_days;
    }

    public function setEstimatedDays(?float $estimated_days): self
    {
        $this->estimated_days = $estimated_days;

        return $this;
    }

    public function getCalculatedDays(): ?float
    {
        return $this->calculated_days;
    }

    public function setCalculatedDays(float $calculated_days): self
    {
        $this->calculated_days = $calculated_days;

        return $this;
    }

    public function getRdNumber(): ?int
    {
        return $this->rd_number;
    }

    public function setRdNumber(?int $rd_number): self
    {
        $this->rd_number = $rd_number;

        return $this;
    }

    public function getLowDays(): ?float
    {
        return $this->low_days;
    }

    public function setLowDays(float $low_days): self
    {
        $this->low_days = $low_days;

        return $this;
    }

    public function getHighDays(): ?float
    {
        return $this->high_days;
    }

    public function setHighDays(float $high_days): self
    {
        $this->high_days = $high_days;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCreatedOn(): ?\DateTimeInterface
    {
        return $this->created_on;
    }

    public function setCreatedOn(\DateTimeInterface $created_on): self
    {
        $this->created_on = $created_on;

        return $this;
    }

    public function getUpdatedOn(): ?\DateTimeInterface
    {
        return $this->updated_on;
    }

    public function setUpdatedOn(?\DateTimeInterface $updated_on): self
    {
        $this->updated_on = $updated_on;

        return $this;
    }

    public function getAutomatic(): ?bool
    {
        return $this->automatic;
    }

    public function setAutomatic(bool $automatic): self
    {
        $this->automatic = $automatic;

        return $this;
    }

    public function getHeader(): ?Header
    {
        return $this->header;
    }

    public function setHeader(?Header $header): self
    {
        $this->header = $header;

        return $this;
    }

    public function getActivityGroup(): ?ActivityGroup
    {
        return $this->activityGroup;
    }

    public function setActivityGroup(?ActivityGroup $activityGroup): self
    {
        $this->activityGroup = $activityGroup;

        return $this;
    }

    public function getProfil(): ?Profil
    {
        return $this->profil;
    }

    public function setProfil(?Profil $profil): self
    {
        $this->profil = $profil;

        return $this;
    }

    public function getCertaintyLevel(): ?CertaintyLevel
    {
        return $this->certaintyLevel;
    }

    public function setCertaintyLevel(?CertaintyLevel $certaintyLevel): self
    {
        $this->certaintyLevel = $certaintyLevel;

        return $this;
    }

    public function getDailyCost(): ?float
    {
        return $this->dailyCost;
    }

    public function setDailyCost(?float $dailyCost): self
    {
        $this->dailyCost = $dailyCost;

        return $this;
    }

}