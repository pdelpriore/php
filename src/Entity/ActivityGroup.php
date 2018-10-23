<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\OrderBy;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ActivityGroupRepository")
 */
class ActivityGroup
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
    public $name;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $rate;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    public $serial_number;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Activity", mappedBy="activityGroup", cascade={"persist"})
     * @OrderBy({"serialNumber" = "ASC"})
     */
    private $activities;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Detail", mappedBy="activityGroup")
     */
    private $details;

    /**
     * @ORM\Column(type="boolean")
     */
    private $automatic;

    /**
     * @ORM\Column(type="boolean")
     */
    private $referent;

    public function __construct()
    {
        $this->activities = new ArrayCollection();
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

    public function getRate(): ?float
    {
        return $this->rate;
    }

    public function setRate(float $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function getSerialNumber(): ?float
    {
        return $this->serial_number;
    }

    public function setSerialNumber(float $serial_number): self
    {
        $this->serial_number = $serial_number;

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
            $activity->setActivityGroup($this);
        }

        return $this;
    }

    public function removeActivity(Activity $activity): self
    {
        if ($this->activities->contains($activity)) {
            $this->activities->removeElement($activity);
            // set the owning side to null (unless already changed)
            if ($activity->getActivityGroup() === $this) {
                $activity->setActivityGroup(null);
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
            $detail->setActivity($this);
        }

        return $this;
    }

    public function removeDetail(Detail $detail): self
    {
        if ($this->details->contains($detail)) {
            $this->details->removeElement($detail);
            // set the owning side to null (unless already changed)
            if ($detail->getActivity() === $this) {
                $detail->setActivity(null);
            }
        }

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

    public function getReferent(): ?bool
    {
        return $this->referent;
    }

    public function setReferent(bool $referent): self
    {
        $this->referent = $referent;

        return $this;
    }
}
