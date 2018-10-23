<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProfilRepository")
 */
class Profil
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
     * @ORM\Column(type="float")
     */
    private $dayly_cost;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Activity", mappedBy="profil")
     */
    private $activities;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Detail", mappedBy="profil")
     */
    private $details;

    /**
     * @ORM\Column(type="boolean")
     */
    private $default_selected;




    public function __construct()
    {
        $this->activities = new ArrayCollection();
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

    public function getDaylyCost(): ?float
    {
        return $this->dayly_cost;
    }

    public function setDaylyCost(float $dayly_cost): self
    {
        $this->dayly_cost = $dayly_cost;

        return $this;
    }

    /**
     * @return Collection|Activity[]
     */
    public function getActivities(): Collection
    {
        return $this->activities;
    }

    public function addActivity(Activity $activity): self
    {
        if (!$this->activities->contains($activity)) {
            $this->activities[] = $activity;
            $activity->setProfil($this);
        }

        return $this;
    }

    public function removeActivity(Activity $activity): self
    {
        if ($this->activities->contains($activity)) {
            $this->activities->removeElement($activity);
            // set the owning side to null (unless already changed)
            if ($activity->getProfil() === $this) {
                $activity->setProfil(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Detail[]
     */
    public function getDetails(): Collection
    {
        return $this->details;
    }

    public function addDetail(Detail $detail): self
    {
        if (!$this->details->contains($detail)) {
            $this->details[] = $detail;
            $detail->setProfil($this);
        }

        return $this;
    }

    public function removeDetail(Detail $detail): self
    {
        if ($this->details->contains($detail)) {
            $this->details->removeElement($detail);
            // set the owning side to null (unless already changed)
            if ($detail->getProfil() === $this) {
                $detail->setProfil(null);
            }
        }

        return $this;
    }

    public function getDefaultSelected(): ?bool
    {
        return $this->default_selected;
    }

    public function setDefaultSelected(bool $default_selected): self
    {
        $this->default_selected = $default_selected;

        return $this;
    }

}