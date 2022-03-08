<?php

namespace App\DataFixtures;

use App\Entity\TestResults;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class TestResultsFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $this->loadVisits($manager);
    }

    private function loadVisits(ObjectManager $manager)
    {
        $i = 0;
        foreach ($this->getTestResultsData() as [$date, $time, $hematocrit, $hemoglobin, $leukocytes, $lymphocytes, $erythrocytes]) {
            $testResults = new TestResults();
            $testResults
                ->setDate($date)
                ->setTime($time)
                ->setHematocrit($hematocrit)
                ->setHemoglobin($hemoglobin)
                ->setLeukocytes($leukocytes)
                ->setLymphocytes($lymphocytes)
                ->setErythrocytes($erythrocytes)
                ->setPatient($this->getReference('patient_' . $i++));
            $manager->persist($testResults);
        }
        $manager->flush();
    }

    private function getTestResultsData()
    {
        return [
            [DateTime::createFromFormat('d.m.Y', '11.11.2021'), DateTime::createFromFormat('H:i', "10:00"),50,13.5,7,3,5.5],
            [DateTime::createFromFormat('d.m.Y', '11.11.2021'), DateTime::createFromFormat('H:i', "11:00"),42,10,5.5,3.3,4],
            [DateTime::createFromFormat('d.m.Y', '11.11.2021'), DateTime::createFromFormat('H:i', "12:00"),58,15,8,1.5,5.2],
        ];
    }

    public function getDependencies(): array
    {
        return [
            PatientFixtures::class
        ];
    }
}
