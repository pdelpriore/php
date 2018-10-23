<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OrderBy;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HeaderRepository")
 */
class Header
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Detail", mappedBy="header", cascade={"persist"})
     * @OrderBy({"activityGroup" = "ASC"})
     */
    private $details;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $application_version;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $redmine_id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_on;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_on;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deleted_on;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CyllenePerson", inversedBy="headers")
     * @ORM\JoinColumn(nullable=false)
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $cyllenePerson;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Application", inversedBy="headers")
     * @ORM\JoinColumn(nullable=false)
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $application;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\InChargePerson", inversedBy="headers")
     * @ORM\JoinColumn(nullable=false)
     * @ORM\OrderBy({"lastName" = "ASC"})
     */
    private $inChargePerson;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Billing", inversedBy="headers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $billing;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $estimate_version;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $sent_on;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $refused_on;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $delivered_on;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $billed_on;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $billNumber;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $agreed_on;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $revision;

    public function __construct()
    {
        $this->setCreatedOn(new \DateTime());
        $this->details = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Detail[]
     */
    public function getDetails(): Collection
    {
        //return $this->details;
        return $this->details;
    }

    public function setDetails($details)
    {
        $this->details = $details;
    }

    public function addDetail(Detail $detail): self
    {
        if (!$this->details->contains($detail)) {
            $this->details[] = $detail;
            $detail->setHeader($this);
        }

        return $this;
    }

    public function removeDetail(Detail $detail): self
    {
        if ($this->details->contains($detail)) {
            $this->details->removeElement($detail);
            // set the owning side to null (unless already changed)
            if ($detail->getHeader() === $this) {
                $detail->setHeader(null);
            }
        }

        return $this;
    }

    public  function addEachDetail($details)
    {
        foreach ($details as $detail) {
            $this->details[] = $detail;
            $detail->setHeader($this);
        }
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getApplicationVersion(): ?string
    {
        return $this->application_version;
    }

    public function setApplicationVersion(string $application_version): self
    {
        $this->application_version = $application_version;

        return $this;
    }

    public function getRedmineId(): ?int
    {
        return $this->redmine_id;
    }

    public function setRedmineId(int $redmine_id): self
    {
        $this->redmine_id = $redmine_id;

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

    public function setUpdatedOn(\DateTimeInterface $updated_on): self
    {
        $this->updated_on = $updated_on;

        return $this;
    }

    public function getDeletedOn(): ?\DateTimeInterface
    {
        return $this->deleted_on;
    }

    public function setDeletedOn(?\DateTimeInterface $deleted_on): self
    {
        $this->deleted_on = $deleted_on;

        return $this;
    }

    public function getCyllenePerson(): ?CyllenePerson
    {
        return $this->cyllenePerson;
    }

    public function setCyllenePerson(?CyllenePerson $cyllenePerson): self
    {
        $this->cyllenePerson = $cyllenePerson;

        return $this;
    }

    public function getApplication(): ?Application
    {
        return $this->application;
    }

    public function setApplication(?Application $application): self
    {
        $this->application = $application;

        return $this;
    }

    public function getInChargePerson(): ?InChargePerson
    {
        return $this->inChargePerson;
    }

    public function setInChargePerson(?InChargePerson $inChargePerson): self
    {
        $this->inChargePerson = $inChargePerson;

        return $this;
    }

    public function getBilling(): ?Billing
    {
        return $this->billing;
    }

    public function setBilling(?Billing $billing): self
    {
        $this->billing = $billing;

        return $this;
    }

    public function getEstimateVersion(): ?string
    {
        return $this->estimate_version;
    }

    public function setEstimateVersion(string $estimate_version): self
    {
        $this->estimate_version = $estimate_version;

        return $this;
    }

    public function getSentOn(): ?\DateTimeInterface
    {
        return $this->sent_on;
    }

    public function setSentOn(?\DateTimeInterface $sent_on): self
    {
        $this->sent_on = $sent_on;

        return $this;
    }

    public function getRefusedOn(): ?\DateTimeInterface
    {
        return $this->refused_on;
    }

    public function setRefusedOn(?\DateTimeInterface $refused_on): self
    {
        $this->refused_on = $refused_on;

        return $this;
    }

    public function getDeliveredOn(): ?\DateTimeInterface
    {
        return $this->delivered_on;
    }

    public function setDeliveredOn(?\DateTimeInterface $delivered_on): self
    {
        $this->delivered_on = $delivered_on;

        return $this;
    }

    public function getBilledOn(): ?\DateTimeInterface
    {
        return $this->billed_on;
    }

    public function setBilledOn(?\DateTimeInterface $billed_on): self
    {
        $this->billed_on = $billed_on;

        return $this;
    }

    public function getBillNumber(): ?string
    {
        return $this->billNumber;
    }

    public function setBillNumber(?string $billNumber): self
    {
        $this->billNumber = $billNumber;

        return $this;
    }

    public function getAgreedOn(): ?\DateTimeInterface
    {
        return $this->agreed_on;
    }

    public function setAgreedOn(?\DateTimeInterface $agreed_on): self
    {
        $this->agreed_on = $agreed_on;

        return $this;
    }

    public function getRevision(): ?string
    {
        return $this->revision;
    }

    public function setRevision(string $revision): self
    {
        $this->revision = $revision;

        return $this;
    }

}