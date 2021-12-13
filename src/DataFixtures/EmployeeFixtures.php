<?php

namespace App\DataFixtures;

use App\Entity\Employee;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EmployeeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $this->loadPatients($manager);
    }

    private function loadPatients(ObjectManager $manager)
    {
        $i = 3;
        $j=0;
        foreach ($this->getEmployeeData() as [$name, $surname]) {
            $employee = new Employee();
            $employee
                ->setName($name)
                ->setSurname($surname)
                ->setUserid($this->getReference('user_' . $i));
            $user = $this->getReference('user_' . $i++);
            $this->addReference('employee_' . $j++, $employee);
            $manager->persist($employee);
            $user->setEmployeeid($employee);
        }

        $manager->flush();
    }

    private function getEmployeeData()
    {
        return [
            ['Piotr', 'Nowak'],
            ['Alicja', 'Kowalska'],
            ['Joanna', 'Ptasińska'],
            ['Andrzej', 'Zając'],
        ];
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class
        ];
    }
}
