<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Form\PatientType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @IsGranted("IS_AUTHENTICATED_FULLY")
 */
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

        $repository = $this->getDoctrine()->getRepository(Patient::class);
        return $this->render('patient/index.html.twig', [
            'patient' => $repository->find($user)
        ]);
    }

    /**
     *
     * @Route("/patient/{patient}/edit", name="patient_edit")
     * @param Request $request
     * @param Patient $patient
     * @return Response
     */
    public function edit(Request $request, Patient $patient): Response
    {
        $form = $this->createForm(PatientType::class, $patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            $this->addFlash('success', 'Pomyślnie zmieniono dane');
            if ($this->isGranted('ROLE_ADMIN') or $this->isGranted('ROLE_EMPLOYEE')) {
                return $this->redirectToRoute('patients');
            } else {
                return $this->redirectToRoute('patient');
            }

        }

        return $this->render('patient/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     *
     * @Route("/patients", name="patients")
     * @param Request $request
     * @return Response
     */
    public function allPatients(Request $request): Response
    {
        $repository = $this->getDoctrine()->getRepository(Patient::class);
        return $this->render('patient/patients.html.twig', [
            'patients' => $repository->findall()
        ]);
    }
}
