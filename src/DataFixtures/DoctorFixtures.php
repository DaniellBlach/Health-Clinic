<?php

namespace App\DataFixtures;

use App\Entity\Doctor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class DoctorFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $this->loadDoctors($manager);
    }
    private function loadDoctors(ObjectManager $manager)
    {
        $i = 3;
        foreach ($this->getDoctorData() as [$specialization, $licenceNumber]) {
            $doctor=new Doctor();
            $doctor
                ->setSpecialization($specialization)
                ->setLicenseNumber($licenceNumber)
                ->setEmployee($this->getReference('employee_' . $i));
            $employee = $this->getReference('employee_' . $i++);
            $manager->persist($doctor);
            $employee->setDoctor($doctor);
        }

        $manager->flush();
    }
    private function getDoctorData()
    {
        return [
            ['Pediatra', '1234567'],
            ['Lekarz rodzinny', '7654321'],
        ];
    }

    public function getDependencies(): array
    {
        return [
            EmployeeFixtures::class
        ];
    }
}
