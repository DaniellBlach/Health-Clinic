<?php

namespace App\Controller;

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

class EmployeeController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @Route("/employee", name="employee")
     */
    public function index(): Response
    {
        $user = $this->security->getUser();
        $repository = $this->getDoctrine()->getRepository(Employee::class);
        return $this->render('employee/index.html.twig', [
            'employee' => $repository->find($user->getemployee())
        ]);
    }

    /**
     * @Route("/employee/add", name="add_employee")
     * @IsGranted("ROLE_ADMIN")
     */
    public function add(Request $request, UserPasswordHasherInterface $userPasswordHasherInterface): Response
    {
        $employee = new Employee();
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $formEmployee = $this->createForm(EmployeeType::class, $employee);
        $form->handleRequest($request);
        $formEmployee->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() && $formEmployee->isSubmitted() && $formEmployee->isValid()) {

            $user->setPassword(
                $userPasswordHasherInterface->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $employee->setUser($user);
            $user->setEmployee($employee);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->persist($employee);
            $entityManager->flush();
            $this->addFlash('success', 'Pomyślnie dodano pracownika');
            return $this->redirectToRoute('index');
        }
        return $this->render('employee/add.html.twig', [
            'registrationForm' => $form->createView(),
            'employeeForm' => $formEmployee->createView(),
        ]);
    }

    /**
     * @Route("/employees", name="employees")
     * @IsGranted ("ROLE_ADMIN")
     * @IsGranted ("ROLE_EMPLOYEE")
     * @param Request $request
     * @return Response
     */
    public function allEmployees(Request $request): Response
    {
        $repository = $this->getDoctrine()->getRepository(Employee::class);
        return $this->render('employee/employees.html.twig', [
            'employees' => $repository->findall()
        ]);
    }

    /**
     * @Route("/employees/{employee}/edit", name="employee_edit")
     * @param Request $request
     * @param Employee $employee
     * @return Response
     */
    public function edit(Request $request, Employee $employee): Response
    {
        $form = $this->createForm(EmployeeType::class, $employee);
        $form->handleRequest($request);
        if ($employee->getDoctor() != null) {
            $doctor = $employee->getDoctor();
            $doctorForm = $this->createForm(DoctorType::class, $doctor);
            $doctorForm->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid() && $doctorForm->isValid() && $doctorForm->isSubmitted()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->flush();
                $this->addFlash('success', 'Pomyślnie zmieniono dane');
                return $this->redirectToRoute('employees');
            }
            return $this->render('employee/edit.html.twig', [
                'form' => $form->createView(),
                'employee' => $employee,
                'doctorForm' => $doctorForm->createView(),
            ]);
        } else {
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->flush();
                $this->addFlash('success', 'Pomyślnie zmieniono dane');
                return $this->redirectToRoute('employees');
            }
            return $this->render('employee/edit.html.twig', [
                'form' => $form->createView(),
                'employee' => $employee,
            ]);
        }
    }
}
