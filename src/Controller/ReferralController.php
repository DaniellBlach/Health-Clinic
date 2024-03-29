<?php

namespace App\Controller;

use App\Entity\Doctor;
use App\Entity\MedicalVisit;
use App\Entity\Patient;
use App\Entity\Referral;
use App\Form\ReferralType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReferralController extends AbstractController
{
    /**
     * @Route("/referral/{referral}", name="referral")
     */
    public function index(Referral $referral): Response
    {
        $repository = $this->getDoctrine()->getRepository(Referral::class);
        return $this->render('referral/index.html.twig', [
            'referral' => $repository->find($referral)
        ]);
    }
    /**
     * @Route("all/patient/referrals/{patient}", name="all_patient_referrals")
     */
    public function allPatientReferrals(Patient $patient): Response
    {
        $repository = $this->getDoctrine()->getRepository(Referral::class);
        return $this->render('referral/all.html.twig', [
            'referrals' => $repository->findBy(['patient'=>$patient]),
            'DoctorReferrals' => false
        ]);
    }

    /**
     * @Route("all/doctor/referrals/{doctor}", name="all_doctor_referrals")
     */
    public function allDoctorReferrals(Doctor $doctor): Response
    {
        $repository = $this->getDoctrine()->getRepository(Referral::class);
        return $this->render('referral/all.html.twig', [
            'referrals' => $repository->findBy(['doctor'=>$doctor]),
            'DoctorReferrals' => true
        ]);
    }

    /**
     * @Route("/add/referral/{medicalVisit}", name="add_referral")
     */
    public function add(Request $request, MedicalVisit $medicalVisit): Response
    {
        $referral = new Referral();
        $form = $this->createForm(ReferralType::class, $referral);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $key = rand(1000, 9999);
            $referral
                ->setRefferalKey($key)
                ->setDateOfIssue(date_create(date("d-m-Y")))
                ->setPatient($medicalVisit->getPatient())
                ->setDoctor($medicalVisit->getDoctor());
            $medicalVisit->setReferral($referral);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($referral);
            $entityManager->flush();
            $this->addFlash('success', 'Pomyślnie wystawiono skierowanie');
            return $this->redirectToRoute('referral', ['referral' => $referral->getId()]);
        }
        return $this->render('referral/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
