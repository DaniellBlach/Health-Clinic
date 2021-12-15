<?php

namespace App\Controller;

use App\Entity\Doctor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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
            'doctor' => $repository->findOneBy(['employee'=>$user->getEmployee()])
        ]);
    }
}
