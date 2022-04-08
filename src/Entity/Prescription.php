<?php

namespace App\Entity;

use App\Repository\PrescriptionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PrescriptionRepository::class)
 */
class Prescription
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
    private $prescriptionKey;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $medicine;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity=PrescriptionPackage::class, inversedBy="prescriptions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $prescriptionPackage;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrescriptionKey(): ?int
    {
        return $this->prescriptionKey;
    }

    public function setPrescriptionKey(int $prescriptionKey): self
    {
        $this->prescriptionKey = $prescriptionKey;

        return $this;
    }

    public function getMedicine(): ?string
    {
        return $this->medicine;
    }

    public function setMedicine(string $medicine): self
    {
        $this->medicine = $medicine;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPrescriptionPackage(): ?PrescriptionPackage
    {
        return $this->prescriptionPackage;
    }

    public function setPrescriptionPackage(?PrescriptionPackage $prescriptionPackage): self
    {
        $this->prescriptionPackage = $prescriptionPackage;

        return $this;
    }
}
