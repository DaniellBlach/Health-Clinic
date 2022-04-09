<?php

namespace App\Controller;

use App\Entity\Doctor;
use App\Entity\MedicalVisit;
use App\Entity\Patient;
use App\Form\MedicalVisitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
            "medicalVisits" => $repository->findBy(['patient'=>$patient])
        ]);
    }

    /**
     * @Route("/medical/visits/add/{patient}/{doctor}", name="add_medical_visit")
     */
    public function add(Request $request,Patient $patient, Doctor $doctor): Response
    {
        $medicalVisit = new MedicalVisit();
        $form = $this->createForm(MedicalVisitType::class, $medicalVisit);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $medicalVisit
                ->setDoctor($doctor)
                ->setPatient($patient)
                ->setDate(date_create(date("d-m-Y")));
            $entityManager=$this->getDoctrine()->getManager();
            $entityManager->persist($medicalVisit);
            $entityManager->flush();
            $this->addFlash('success', 'Pomyślnie dodano wizytę');
            return $this->redirectToRoute('medical_visits',['patient'=>$patient->getId()]);
        }
        return $this->render('medical_visit/add.html.twig', [
            "form" => $form->createView(),
            "patient" => $patient
        ]);
    }
}
