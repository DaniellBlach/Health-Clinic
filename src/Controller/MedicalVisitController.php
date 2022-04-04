<?php

namespace App\Controller;

use App\Entity\MedicalVisit;
use App\Entity\Patient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MedicalVisitController extends AbstractController
{
    /**
     * @Route("/medical/visits/{patient}", name="medical_visits")
     */
    public function index(Patient $patient): Response
    {
        $repository = $this->getDoctrine()->getRepository(MedicalVisit::class);
        return $this->render('medical_visit/index.html.twig', [
            "medicalVisits" => $repository->findAll()
        ]);
    }
}
