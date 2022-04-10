<?php

namespace App\DataFixtures;

use App\Entity\PrescriptionPackage;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PrescriptionPackageFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $this->loadPrescriptionPackages($manager);
    }

    public function loadPrescriptionPackages(ObjectManager $manager)
    {
        $i=0;
        foreach ($this->getPrescriptionPackageData() as [$packageKey, $packageCode, $dateOfIssue,$expirationDate]) {
            $prescriptionPackage=new PrescriptionPackage();
            $prescriptionPackage
                ->setPackageKey($packageKey)
                ->setPackageCode($packageCode)
                ->setDateOfIssue($dateOfIssue)
                ->setExpirationDate($expirationDate);
            $this->addReference('prescriptionPackage_' . $i++, $prescriptionPackage);
            $manager->persist($prescriptionPackage);
        }
        $manager->flush();
    }

    public function getPrescriptionPackageData(): array
    {
        return [[5467, "546712312312312", DateTime::createFromFormat('d.m.Y', '15.01.2022'), DateTime::createFromFormat('d.m.Y', '15.02.2022')],
            [1432, "143212312312312", DateTime::createFromFormat('d.m.Y', '11.03.2022'), DateTime::createFromFormat('d.m.Y', '11.04.2022')],
            [9376, "937612312312312", DateTime::createFromFormat('d.m.Y', '18.03.2022'), DateTime::createFromFormat('d.m.Y', '18.04.2022')]];
    }
}
