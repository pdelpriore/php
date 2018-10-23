<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="App\Repository\ActivityRepository")
 */
class Activity
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
     * @ORM\ManyToOne(targetEntity="App\Entity\ActivityGroup", inversedBy="activities")
     * @ORM\JoinColumn(nullable=false)
     */
    private $activityGroup;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Profil", inversedBy="activities")
     * @ORM\JoinColumn(nullable=false)
     */
    private $profil;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $rate;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $minHours;

    /**
     * @ORM\Column(type="float")
     */
    private $serialNumber;


    public function __construct()
    {
        $this->details = new ArrayCollection();
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

    public function getRate(): ?float
    {
        return $this->rate;
    }

    public function setRate(?float $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function getMinHours(): ?int
    {
        return $this->minHours;
    }

    public function setMinHours(?int $minHours): self
    {
        $this->minHours = $minHours;

        return $this;
    }

    public function getSerialNumber(): ?float
    {
        return $this->serialNumber;
    }

    public function setSerialNumber(float $serialNumber): self
    {
        $this->serialNumber = $serialNumber;

        return $this;
    }
}
