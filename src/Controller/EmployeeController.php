<?php

namespace App\Controller;

use App\Entity\Employee;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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
}
