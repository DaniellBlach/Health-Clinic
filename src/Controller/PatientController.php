<?php

namespace App\Controller;

use App\Entity\Patient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class PatientController extends AbstractController
{
    private $security;
    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    /**
     * @Route("/patient", name="patient")
     */
    public function index(): Response
    {
        $user = $this->security->getUser();

        $repository=$this->getDoctrine()->getRepository(Patient::class);
        return $this->render('patient/index.html.twig', [
            'patient'=>$repository->find($user)
        ]);
    }
}
