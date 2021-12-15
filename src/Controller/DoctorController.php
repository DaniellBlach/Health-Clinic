<?php

namespace App\Controller;

use App\Entity\Doctor;
use App\Entity\Employee;
use App\Entity\User;
use App\Form\DoctorType;
use App\Form\EmployeeType;
use App\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class DoctorController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @Route("/doctor", name="doctor")
     */
    public function index(): Response
    {
        $user = $this->security->getUser();
        $repository = $this->getDoctrine()->getRepository(Doctor::class);
        return $this->render('doctor/index.html.twig', [
            'doctor' => $repository->findOneBy(['employee' => $user->getEmployee()])
        ]);
    }

    /**
     * @Route("/doctor/add", name="add_doctor")
     * @IsGranted("ROLE_ADMIN")
     */
    public function add(Request $request, UserPasswordHasherInterface $userPasswordHasherInterface): Response
    {
        $employee = new Employee();
        $user = new User();
        $doctor = new Doctor();
        $form = $this->createForm(UserType::class, $user);
        $employeeForm = $this->createForm(EmployeeType::class, $employee);
        $doctorForm = $this->createForm(DoctorType::class, $doctor);
        $form->handleRequest($request);
        $employeeForm->handleRequest($request);
        $doctorForm->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() && $employeeForm->isSubmitted() && $employeeForm->isValid() && $doctorForm->isSubmitted() && $doctorForm->isValid()) {
            $user->setPassword(
                $userPasswordHasherInterface->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setEmployee($employee);
            $user->setRoles(["ROLE_DOCTOR"]);
            $employee->setUser($user);
            $employee->setDoctor($doctor);
            $doctor->setEmployee($employee);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user, $doctor, $employee);
            $entityManager->flush();
            $this->addFlash('success', 'Pomyślnie dodano nowego lekarza');
            return $this->redirectToRoute('index');
        }
        return $this->render('doctor/add.html.twig', [
            'registrationForm' => $form->createView(),
            'employeeForm' => $employeeForm->createView(),
            'doctorForm' => $doctorForm->createView(),
        ]);
    }
}
