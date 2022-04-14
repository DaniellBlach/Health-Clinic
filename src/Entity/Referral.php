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
    private $refferalKey;

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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRefferalKey(): ?int
    {
        return $this->refferalKey;
    }

    public function setRefferalKey(int $refferalKey): self
    {
        $this->refferalKey = $refferalKey;

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
}
