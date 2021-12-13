<?php

namespace App\Entity;

use App\Repository\DoctorRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DoctorRepository::class)
 */
class Doctor
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $specialization;

    /**
     * @ORM\Column(type="integer")
     */
    private $licenseNumber;

    /**
     * @ORM\OneToOne(targetEntity=employee::class, inversedBy="doctor", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $employee;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSpecialization(): ?string
    {
        return $this->specialization;
    }

    public function setSpecialization(string $specialization): self
    {
        $this->specialization = $specialization;

        return $this;
    }

    public function getLicenseNumber(): ?int
    {
        return $this->licenseNumber;
    }

    public function setLicenseNumber(int $licenseNumber): self
    {
        $this->licenseNumber = $licenseNumber;

        return $this;
    }

    public function getEmployee(): ?employee
    {
        return $this->employee;
    }

    public function setEmployee(employee $employee): self
    {
        $this->employee = $employee;

        return $this;
    }
}
