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
     * @ORM\Column(type="string", length=7)
     */
    private $licenseNumber;

    /**
     * @ORM\OneToOne(targetEntity=Employee::class, inversedBy="doctor", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false,onDelete="CASCADE")
     */
    private $employee;

    /**
     * @ORM\Column(type="text")
     */
    private $biography;

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

    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    public function setEmployee(Employee $employee): self
    {
        $this->employee = $employee;

        return $this;
    }

    public function getBiography(): ?string
    {
        return $this->biography;
    }

    public function setBiography(string $biography): self
    {
        $this->biography = $biography;

        return $this;
    }

    public function __toString()
    {
        return 'Dr. ' . $this->employee->getName() . ' ' . $this->employee->getSurname();
    }
}
