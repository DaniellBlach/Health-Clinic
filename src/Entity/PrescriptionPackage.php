<?php

namespace App\Entity;

use App\Repository\PrescriptionPackageRepository;
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
}
