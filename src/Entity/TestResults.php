<?php

namespace App\Entity;

use App\Repository\TestResultsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TestResultsRepository::class)
 */
class TestResults
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Patient::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $patient;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="time")
     */
    private $time;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $hematocrit;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $hemoglobin;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $leukocytes;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $lymphocytes;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $erythrocytes;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(\DateTimeInterface $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getHematocrit(): ?float
    {
        return $this->hematocrit;
    }

    public function setHematocrit(?float $Hematocrit): self
    {
        $this->hematocrit = $Hematocrit;

        return $this;
    }

    public function getHemoglobin(): ?float
    {
        return $this->hemoglobin;
    }

    public function setHemoglobin(?float $Hemoglobin): self
    {
        $this->hemoglobin = $Hemoglobin;

        return $this;
    }

    public function getLeukocytes(): ?float
    {
        return $this->leukocytes;
    }

    public function setLeukocytes(?float $leukocytes): self
    {
        $this->leukocytes = $leukocytes;

        return $this;
    }

    public function getLymphocytes(): ?float
    {
        return $this->lymphocytes;
    }

    public function setLymphocytes(?float $lymphocytes): self
    {
        $this->lymphocytes = $lymphocytes;

        return $this;
    }

    public function getErythrocytes(): ?float
    {
        return $this->erythrocytes;
    }

    public function setErythrocytes(?float $erythrocytes): self
    {
        $this->erythrocytes = $erythrocytes;

        return $this;
    }
}
