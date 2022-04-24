<?php

namespace App\Entity;

use App\Repository\ReferralRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReferralRepository::class)
 */
class Referral
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
    private $referralKey;

    /**
     * @ORM\Column(type="date")
     */
    private $dateOfIssue;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $diagnosis;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $additionalInformation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $typeOfReferral;

    /**
     * @ORM\ManyToOne(targetEntity=Patient::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $patient;

    /**
     * @ORM\ManyToOne(targetEntity=Doctor::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $doctor;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReferralKey(): ?int
    {
        return $this->referralKey;
    }

    public function setRefferalKey(int $referralKey): self
    {
        $this->referralKey = $referralKey;

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

    public function getDiagnosis(): ?string
    {
        return $this->diagnosis;
    }

    public function setDiagnosis(string $diagnosis): self
    {
        $this->diagnosis = $diagnosis;

        return $this;
    }

    public function getAdditionalInformation(): ?string
    {
        return $this->additionalInformation;
    }

    public function setAdditionalInformation(string $additionalInformation): self
    {
        $this->additionalInformation = $additionalInformation;

        return $this;
    }

    public function getTypeOfReferral(): ?string
    {
        return $this->typeOfReferral;
    }

    public function setTypeOfReferral(string $typeOfReferral): self
    {
        $this->typeOfReferral = $typeOfReferral;

        return $this;
    }

    public function getPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setPatient(?Patient $patient): self
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
}
