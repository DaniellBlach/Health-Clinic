<?php

namespace App\Entity;

use App\Repository\MedicalVisitRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MedicalVisitRepository::class)
 */
class MedicalVisit
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=patient::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $patient;

    /**
     * @ORM\ManyToOne(targetEntity=Doctor::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $doctor;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $symptoms;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $diagnosis;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $recommendations;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $additionalInformation;

    /**
     * @ORM\OneToOne(targetEntity=PrescriptionPackage::class, cascade={"persist", "remove"})
     */
    private $prescriptionPackage;

    /**
     * @ORM\OneToOne(targetEntity=Referral::class, cascade={"persist", "remove"})
     */
    private $referral;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPatient(): ?patient
    {
        return $this->patient;
    }

    public function setPatient(?patient $patient): self
    {
        $this->patient = $patient;

        return $this;
    }

    public function getDoctor(): ?Doctor
    {
        return $this->doctor;
    }

    public function setDoctor(?Doctor $doctor): self
    {
        $this->doctor = $doctor;

        return $this;
    }

    public function getSymptoms(): ?string
    {
        return $this->symptoms;
    }

    public function setSymptoms(?string $symptoms): self
    {
        $this->symptoms = $symptoms;

        return $this;
    }

    public function getDiagnosis(): ?string
    {
        return $this->diagnosis;
    }

    public function setDiagnosis(?string $diagnosis): self
    {
        $this->diagnosis = $diagnosis;

        return $this;
    }

    public function getRecommendations(): ?string
    {
        return $this->recommendations;
    }

    public function setRecommendations(?string $recommendations): self
    {
        $this->recommendations = $recommendations;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getAdditionalInformation(): ?string
    {
        return $this->additionalInformation;
    }

    public function setAdditionalInformation(?string $additionalInformation): self
    {
        $this->additionalInformation = $additionalInformation;

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

    public function getReferral(): ?Referral
    {
        return $this->referral;
    }

    public function setReferral(?Referral $referral): self
    {
        $this->referral = $referral;

        return $this;
    }
}
