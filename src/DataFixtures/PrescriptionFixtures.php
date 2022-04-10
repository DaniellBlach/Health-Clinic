<?php

namespace App\DataFixtures;

use App\Entity\Prescription;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PrescriptionFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $this->loadPrescriptions($manager);
        $manager->flush();
    }

    public function loadPrescriptions(ObjectManager $manager)
    {
        $i = 0;
        foreach ($this->getPrescriptionData() as [$prescriptionKey, $medicine, $quantity]) {
            $prescription = new Prescription();
            $prescription
                ->setPrescriptionKey($prescriptionKey)
                ->setQuantity($quantity)
                ->setMedicine($medicine)
                ->setPrescriptionPackage($this->getReference('prescriptionPackage_' . $i++));
            if ($i == 3) {
                $i = 0;
            }
            $manager->persist($prescription);
        }
        $manager->flush();
    }

    public function getPrescriptionData(): array
    {
        return [[1234, "Abra 100mg 30 sztuk", 1],
            [9681, "Abra 100mg 30 sztuk", 1],
            [3950, "Abra 100mg 30 sztuk", 1],
            [6682, "Edronax 200mg 20 sztuk", 2],
            [2409, "Edronax 200mg 20 sztuk", 2],
            [4200, "Edronax 200mg 20 sztuk", 2],
            [6745, "Maalox 400mg 20 sztuk", 2],
            [4455, "Maalox 400mg 20 sztuk", 2],
            [1551, "Maalox 400mg 20 sztuk", 2]];
    }

    public function getDependencies(): array
    {
        return [
            PrescriptionPackageFixtures::class,
        ];
    }
}
