<?php

namespace App\Controller;

use App\Entity\Doctor;
use App\Entity\MedicalVisit;
use App\Entity\Patient;
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
     * @Route("/all/doctor/prescription/packages/{doctor}", name="all_doctor_prescription_packages")
     */
    public function allDoctorPrescriptionPackages(Doctor $doctor): Response
    {
        $repository = $this->getDoctrine()->getRepository(PrescriptionPackage::class);
        $prescriptionPackages = $repository->findby(['doctor' => $doctor]);
        return $this->render('prescription_package/all.html.twig', [
            'prescriptionPackages' => $prescriptionPackages,
            'doctorPrescriptionPackages' => true
        ]);
    }

    /**
     * @Route("/all/patient/prescription/packages/{patient}", name="all_patient_prescription_packages")
     */
    public function allPatientPrescriptionPackages(Patient $patient): Response
    {
        $repository = $this->getDoctrine()->getRepository(PrescriptionPackage::class);
        $prescriptionPackages = $repository->findby(['patient' => $patient]);
        return $this->render('prescription_package/all.html.twig', [
            'prescriptionPackages' => $prescriptionPackages,
            'doctorPrescriptionPackages' => false
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
            $timeBetweenDates = (array)date_diff($form->get('expirationDate')->getData(), date_create(date("d-m-Y")));
            if ($form->get('expirationDate')->getData() < date_create(date("d-m-Y"))) {
                $this->addFlash('error', 'Podano niewłaściwą datę ważności');
            } elseif ($timeBetweenDates['days'] < 7) {
                $this->addFlash('error', 'Minimalna data ważności wynosi 7 dni');
            } elseif ($timeBetweenDates['days'] > 365) {
                $this->addFlash('error', 'Maksymalna data ważności wynosi 365 dni');
            } else {
                $key = rand(1000, 9999);
                $pesel = $medicalVisit->getPatient()->getPesel();
                $code = $key . $pesel;
                $prescriptionPackage
                    ->setDateOfIssue(date_create(date("d-m-Y")))
                    ->setPackageCode($code)
                    ->setPackageKey($key)
                    ->setDoctor($medicalVisit->getDoctor())
                    ->setPatient($medicalVisit->getPatient());
                $entityManager = $this->getDoctrine()->getManager();
                $medicalVisit->setPrescriptionPackage($prescriptionPackage);
                $entityManager->persist($prescriptionPackage);
                $entityManager->flush();
                $this->addFlash('success', 'Pomyślnie wystawiono receptę');
                return $this->redirectToRoute('prescription_package', ['package' => $prescriptionPackage->getId()]);
            }
        }
        return $this->render('prescription_package/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
