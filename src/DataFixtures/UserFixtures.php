<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private UserPasswordEncoderInterface $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
    }

    private function loadUsers(ObjectManager $manager)
    {
        $i = 0;
        foreach ($this->getUsersData() as [$email, $role, $password]) {
            $user = new User();
            $user
                ->setEmail($email)
                ->setRoles([$role])
                ->setPassword($this->encoder->encodePassword($user, $password));
            $this->addReference('user_' . $i++, $user);
            $manager->persist($user);
        }

        $manager->flush();
    }
    private function getUsersData()
    {
        return [
            ['pacjent1@klinika.pl', 'ROLE_PATIENT', 'admin123'],
            ['pacjent2@klinika.pl', 'ROLE_PATIENT', 'admin123'],
            ['pacjent3@klinika.pl', 'ROLE_PATIENT', 'admin123'],
            ['admin@klinika.pl', 'ROLE_ADMIN', 'admin123'],
            ['pracownik1@klinika.pl', 'ROLE_EMPLOYEE', 'admin123'],
            ['pracownik2@klinika.pl', 'ROLE_EMPLOYEE', 'admin123'],
            ['lekarz1@klinika.pl', 'ROLE_DOCTOR', 'admin123'],
            ['lekarz2@klinika.pl', 'ROLE_DOCTOR', 'admin123'],
        ];
    }

}
