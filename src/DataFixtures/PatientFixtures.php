<?php

namespace App\DataFixtures;

use App\Entity\Patient;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PatientFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $this->loadPatients($manager);
    }
    private function loadPatients(ObjectManager $manager)
    {
        $i = 0;
        foreach ($this->getPatientsData() as [$name, $surname, $pesel, $date_of_birth, $sex, $phone_number]) {
            $patient = new Patient();
            $patient
                ->setName($name)
                ->setSurname($surname)
                ->setPesel($pesel)
                ->setDateOfBirth($date_of_birth)
                ->setSex($sex)
                ->setPhoneNumber($phone_number)
                ->setUserid($this->getReference('user_' . $i));
            $user=$this->getReference('user_' . $i++);
            $manager->persist($patient);
            $user->setPatientid($patient);
        }

        $manager->flush();
    }
    private function getPatientsData()
    {
        return [
            ['Jan', 'Nowak', '12312312311',DateTime::createFromFormat('d.m.Y', '11.11.2000'),'mężczyzna','123123123'],
            ['Ala', 'Kowalska', '12312312312',DateTime::createFromFormat('d.m.Y', '01.12.1990'),'kobieta','123456789'],
            ['Michał', 'Kowalski', '12312312313',DateTime::createFromFormat('d.m.Y', '23.11.1973'),'mężczyzna','987654321'],
        ];
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class
        ];
    }
}
