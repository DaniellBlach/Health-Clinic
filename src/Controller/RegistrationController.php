<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Entity\User;
use App\Form\PatientType;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasherInterface): Response
    {
        $user = new User();
        $patient = new Patient();
        $form = $this->createForm(UserType::class, $user);
        $formPatient = $this->createForm(PatientType::class, $patient);
        $form->handleRequest($request);
        $formPatient->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() && $formPatient->isSubmitted() && $formPatient->isValid()) {

            $user->setPassword(
                $userPasswordHasherInterface->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setRoles(["ROLE_PATIENT"]);
            $patient->setUserid($user);
            $user->setPatientid($patient);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->persist($patient);
            $entityManager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
            'patientForm' => $formPatient->createView(),
        ]);
    }
}
