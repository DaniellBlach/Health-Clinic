<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Entity\User;
use App\Form\EmployeeType;
use App\Form\RegistrationFormType;
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
            'employee' => $repository->find($user->getemployeeid())
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
        $form = $this->createForm(RegistrationFormType::class, $user);
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
            $employee->setUserid($user);
            $user->setEmployeeid($employee);
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
     *
     * @Route("/employees", name="employees")
     * @param Request $request
     * @return Response
     */
    public function allPatients(Request $request): Response
    {
        $repository = $this->getDoctrine()->getRepository(Employee::class);
        return $this->render('employee/employees.html.twig', [
            'employees' => $repository->findall()
        ]);
    }
}
