<?php

namespace App\Controller;

use App\Entity\Prescription;
use App\Entity\PrescriptionPackage;
use App\Form\PrescriptionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PrescriptionController extends AbstractController
{
    /**
     * @Route("/add/prescription/{prescriptionPackage}", name="add_prescription")
     */
    public function add(Request $request, PrescriptionPackage $prescriptionPackage): Response
    {
        $prescription = new Prescription();
        $form = $this->createForm(PrescriptionType::class, $prescription);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $key=rand(1000,9999);
            $prescription
                ->setPrescriptionPackage($prescriptionPackage)
                ->setPrescriptionKey($key);
            $entityManager=$this->getDoctrine()->getManager();
            $entityManager->persist($prescription);
            $entityManager->flush();
            $this->addFlash('success', 'Pomyślnie dodano lek');
            return $this->redirectToRoute('prescription_package',['package'=>$prescriptionPackage->getId()]);
        }
        return $this->render('prescription/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
