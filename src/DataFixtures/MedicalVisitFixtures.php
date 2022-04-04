<?php

namespace App\DataFixtures;

use App\Entity\MedicalVisit;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MedicalVisitFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $this->loadMedicalVisits($manager);
    }

    public function loadMedicalVisits(ObjectManager $manager)
    {
        foreach ($this->getMedicalVisitsData() as [$symptoms, $diagnosis, $recommendations,$date,$additionalInfo]) {
            $MedicalVisit = new MedicalVisit();
            $MedicalVisit
                ->setPatient($this->getReference("patient_0"))
                ->setDoctor($this->getReference("doctor_0"))
                ->setSymptoms($symptoms)
                ->setDiagnosis($diagnosis)
                ->setRecommendations($recommendations)
                ->setAdditionalInformation($additionalInfo)
                ->setDate($date);
            $manager->persist($MedicalVisit);
        }
        $manager->flush();
    }

    public function getMedicalVisitsData()
    {
        return [
            ["Ból gardła, kaszel, katar, wysoka temperatura", "grypa", "zażywać leki z recepty zgodnie z zaleceniami",DateTime::createFromFormat('d.m.Y', '15.01.2022'),"-"],
            ["Opuchnięta twarz, problemy z oddychaniem", "uczulenie", "zażywać leki z recepty, w wypadku nasilenia się symptomów bezwzwłocznie udać się do szpitala",DateTime::createFromFormat('d.m.Y', '11.03.2022'),"-"],
            ["-", "-", "-",DateTime::createFromFormat('d.m.Y', '18.03.2022'),"wizyta kontrolna"],
        ];
    }

    public function getDependencies(): array
    {
        return [
            PatientFixtures::class,
            DoctorFixtures::class
        ];
    }
}
