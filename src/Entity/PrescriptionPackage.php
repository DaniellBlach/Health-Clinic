<?php

namespace App\Entity;

use App\Repository\PrescriptionPackageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PrescriptionPackageRepository::class)
 */
class PrescriptionPackage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $packageKey;

    /**
     * @ORM\Column(type="integer")
     */
    private $packageCode;

    /**
     * @ORM\OneToMany(targetEntity=Prescription::class, mappedBy="prescriptionPackage", orphanRemoval=true)
     */
    private $prescriptions;

    /**
     * @ORM\Column(type="date")
     */
    private $dateOfIssue;

    /**
     * @ORM\Column(type="date")
     */
    private $expirationDate;

    public function __construct()
    {
        $this->prescriptions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPackageKey(): ?int
    {
        return $this->packageKey;
    }

    public function setPackageKey(int $packageKey): self
    {
        $this->packageKey = $packageKey;

        return $this;
    }

    public function getPackageCode(): ?int
    {
        return $this->packageCode;
    }

    public function setPackageCode(int $packageCode): self
    {
        $this->packageCode = $packageCode;

        return $this;
    }

    /**
     * @return Collection<int, Prescription>
     */
    public function getPrescriptions(): Collection
    {
        return $this->prescriptions;
    }

    public function addPrescription(Prescription $prescription): self
    {
        if (!$this->prescriptions->contains($prescription)) {
            $this->prescriptions[] = $prescription;
            $prescription->setPrescriptionPackage($this);
        }

        return $this;
    }

    public function removePrescription(Prescription $prescription): self
    {
        if ($this->prescriptions->removeElement($prescription)) {
            // set the owning side to null (unless already changed)
            if ($prescription->getPrescriptionPackage() === $this) {
                $prescription->setPrescriptionPackage(null);
            }
        }

        return $this;
    }

    public function getDateOfIssue(): ?\DateTimeInterface
    {
        return $this->dateOfIssue;
    }

    public function setDateOfIssue(\DateTimeInterface $dateOfIssue): self
    {
        $this->dateOfIssue = $dateOfIssue;

        return $this;
    }

    public function getExpirationDate(): ?\DateTimeInterface
    {
        return $this->expirationDate;
    }

    public function setExpirationDate(\DateTimeInterface $expirationDate): self
    {
        $this->expirationDate = $expirationDate;

        return $this;
    }
}
