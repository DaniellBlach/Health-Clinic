<?php

namespace App\DataFixtures;

use App\Entity\DateOfVisit;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints\Time;

class DateOfVisitFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $this->loadVisits($manager);
    }

    private function loadVisits(ObjectManager $manager)
    {
        $i = 0;
        foreach ($this->getVisitData() as [$type, $date, $time]) {
            $visit = new DateOfVisit();
            $visit
                ->setDate($date)
                ->setTime($time)
                ->setTypeOfVisit($type)
                ->setDoctor($this->getReference('doctor_0'));
            if ($i <= 2) {
                $visit->setPatient($this->getReference('patient_' . $i++));
            } else {
                $visit->setPatient(null);
            }
            $manager->persist($visit);
        }
        $manager->flush();
    }

    private function getVisitData()
    {
        return [
            ['wizyta w przychodni', DateTime::createFromFormat('d.m.Y', '11.11.2022'), DateTime::createFromFormat('H:i', "10:00")],
            ['wizyta w przychodni', DateTime::createFromFormat('d.m.Y', '11.11.2022'), DateTime::createFromFormat('H:i', "11:00")],
            ['wizyta w przychodni', DateTime::createFromFormat('d.m.Y', '11.11.2022'), DateTime::createFromFormat('H:i', "12:00")],
            [null, DateTime::createFromFormat('d.m.Y', '11.11.2022'), DateTime::createFromFormat('H:i', "13:00")],
            [null, DateTime::createFromFormat('d.m.Y', '11.11.2022'), DateTime::createFromFormat('H:i', "14:00")],
            [null, DateTime::createFromFormat('d.m.Y', '11.11.2022'), DateTime::createFromFormat('H:i', "15:00")],
        ];
    }

    public function getDependencies(): array
    {
        return [
            DoctorFixtures::class
        ];
    }

}
