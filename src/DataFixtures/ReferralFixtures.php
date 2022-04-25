<?php

namespace App\DataFixtures;

use App\Entity\Referral;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ReferralFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $this->loadReferrals($manager);
    }

    public function loadReferrals(ObjectManager $manager)
    {
        $i = 0;
        foreach ($this->getReferralData() as [$referralKey, $dateOfIssue, $typeOfReferral, $diagnosis, $additionalInformation]) {
            $referral=new Referral();
            $referral
                ->setRefferalKey($referralKey)
                ->setDateOfIssue($dateOfIssue)
                ->setTypeOfReferral($typeOfReferral)
                ->setDiagnosis($diagnosis)
                ->setAdditionalInformation($additionalInformation)
                ->setDoctor($this->getReference("doctor_0"))
                ->setPatient($this->getReference("patient_0"));
            $this->addReference('referral_' . $i++, $referral);
            $manager->persist($referral);
        }
        $manager->flush();
    }

    public function getReferralData(): array
    {
        return [[5467, DateTime::createFromFormat('d.m.Y', '15.01.2022'), 'skierowanie do kardiologa', 'problemy z krążeniem', 'udać się jak najszybciej do specialisty'],
            [1432, DateTime::createFromFormat('d.m.Y', '11.03.2022'), 'skierowanie do dermatologa', 'zmianny skórne', 'brak']
        ];
    }

    public function getDependencies()
    {
        return [
            PatientFixtures::class,
            DoctorFixtures::class,
        ];
    }
}
