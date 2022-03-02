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
        $j=0;
        foreach ($this->getDoctorData() as [$specialization, $licenceNumber,$biography]) {
            $doctor=new Doctor();
            $doctor
                ->setSpecialization($specialization)
                ->setLicenseNumber($licenceNumber)
                ->setBiography($biography)
                ->setEmployee($this->getReference('employee_' . $i));
            $this->addReference('doctor_' . $j++, $doctor);
            $employee = $this->getReference('employee_' . $i++);
            $manager->persist($doctor);
            $employee->setDoctor($doctor);
        }

        $manager->flush();
    }
    private function getDoctorData()
    {
        return [
            ['Lekarz rodzinny', '1234567','Dr Andrzej jest lekarzem rodzinnym, specjalistą diagnostyki wydolnościowej z zamiłowaniem do sportu i zdrowego trybu życia oraz doradcą medycznym i koncepcyjnym wielu firm z sektora mHealth i diagnostyki medycznej. Na co dzień zajmuje się diagnostyką, profilaktyką oraz leczeniem sportowców zawodowych i miłośników sportów rekreacyjnych.'],
            ['Lekarz rodzinny', '7654321','Dr Kamil jest lekarzem rodzinnym, absolwentem Wydziału Lekarskiego Uniwersytetu Medycznego w Gdańsku, ukończył także podyplomowe studia z Psychologii Klinicznej na Gdańskim Uniwersytecie Medycznym. Jego szczególne zainteresowania to profilaktyka chorób układu krążenia i innych chorób cywilizacyjnych, infekcje dróg oddechowych, nadciśnienie tętnicze, opieka nad pacjentem przewlekle chorym.'],
        ];
    }

    public function getDependencies(): array
    {
        return [
            EmployeeFixtures::class
        ];
    }
}
