<?php

namespace App\Controller;

use App\Entity\MedicalVisit;
use App\Entity\PrescriptionPackage;
use App\Form\PrescriptionPackageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PrescriptionPackageController extends AbstractController
{
    /**
     * @Route("/prescription/package/{package}", name="prescription_package")
     */
    public function index(PrescriptionPackage $package): Response
    {
        $repository = $this->getDoctrine()->getRepository(PrescriptionPackage::class);
        $prescriptionPackage = $repository->find($package);
        $prescriptions = $prescriptionPackage->getPrescriptions();
        return $this->render('prescription_package/index.html.twig', [
            'package' => $package,
            'prescriptions' => $prescriptions
        ]);
    }

    /**
     * @Route("/add/prescription/package/{medicalVisit}", name="add_prescription_package")
     */
    public function add(Request $request, MedicalVisit $medicalVisit): Response
    {
        $prescriptionPackage = new PrescriptionPackage();
        $form = $this->createForm(PrescriptionPackageType::class, $prescriptionPackage);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $key = rand(1000, 9999);
            $pesel = $medicalVisit->getPatient()->getPesel();
            $code = $key + $pesel;
            dump($key,$pesel,$code);
            $prescriptionPackage
                ->setDateOfIssue(date_create(date("d-m-Y")))
                ->setPackageCode($code)
                ->setPackageKey($key);
            $entityManager = $this->getDoctrine()->getManager();
            $medicalVisit->setPrescriptionPackage($prescriptionPackage);
            $entityManager->persist($prescriptionPackage);
            $entityManager->flush();
            $this->addFlash('success', 'Pomyślnie wystawiono receptę');
            return $this->redirectToRoute('prescription_package',['package'=>$prescriptionPackage->getId()]);
        }
        return $this->render('prescription_package/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
