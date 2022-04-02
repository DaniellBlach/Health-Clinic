<?php

namespace App\DataFixtures;

use App\Entity\MedicalVisit;
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
        foreach ($this->getMedicalVisitsData() as [$symptoms, $diagnosis, $recommendations]) {
            $MedicalVisit = new MedicalVisit();
            $MedicalVisit
                ->setPatient($this->getReference("patient_0"))
                ->setDoctor($this->getReference("doctor_0"))
                ->setSymptoms($symptoms)
                ->setDiagnosis($diagnosis)
                ->setRecommendations($recommendations);
            $manager->persist($MedicalVisit);
        }
        $manager->flush();
    }

    public function getMedicalVisitsData()
    {
        return [
            ["Ból gardła, kaszel, katar, wysoka temperatura", "grypa", "zażywać leki z recepty zgodnie z zaleceniami"],
            ["Opuchnięta twarz, problemy z oddychaniem", "uczulenie", "zażywać leki z recepty, w wypadku nasilenia się symptomów bezwzwłocznie udać się do szpitala"],
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
