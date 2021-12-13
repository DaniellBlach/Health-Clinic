<?php

namespace App\Entity;

use App\Repository\EmployeeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EmployeeRepository::class)
 */
class Employee
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $surname;

    /**
     * @ORM\OneToOne(targetEntity=user::class, inversedBy="employeeid", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false,onDelete="CASCADE")
     */
    private $userid;

    /**
     * @ORM\OneToOne(targetEntity=Doctor::class, mappedBy="employee", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true,onDelete="CASCADE")
     */
    private $doctor;

    public function getId(): ?int
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

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getUserid(): ?user
    {
        return $this->userid;
    }

    public function setUserid(user $userid): self
    {
        $this->userid = $userid;

        return $this;
    }

    public function getDoctor(): ?Doctor
    {
        return $this->doctor;
    }

    public function setDoctor(Doctor $doctor): self
    {
        // set the owning side of the relation if necessary
        if ($doctor->getEmployee() !== $this) {
            $doctor->setEmployee($this);
        }

        $this->doctor = $doctor;

        return $this;
    }
}
