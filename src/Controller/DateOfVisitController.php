<?php

namespace App\Controller;

use App\Entity\DateOfVisit;
use App\Form\SignUpForVisitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class DateOfVisitController extends AbstractController
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @Route("/visits", name="visits")
     */
    public function index(): Response
    {
        $repository = $this->getDoctrine()->getRepository(DateOfVisit::class);
        return $this->render('date_of_visit/index.html.twig', [
            'visits' => $repository->findAll()
        ]);
    }

    /**
     * @Route("/available/visits", name="available_visits")
     */
    public function available(): Response
    {
        $repository = $this->getDoctrine()->getRepository(DateOfVisit::class);
        return $this->render('date_of_visit/available.html.twig', [
            'visits' => $repository->findBy(['patient' => null])
        ]);
    }

    /**
     * @Route("/sign/up/{visit}", name="sign_up")
     * @param Request $request
     * @param DateOfVisit $visit
     * @return Response
     */
    public function sign(Request $request, DateOfVisit $visit): Response
    {
        $user = $this->security->getUser();
        $form = $this->createForm(SignUpForVisitType::class, $visit);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $visit->setPatient($user->getPatient());
            $entityManager->persist($visit);
            $entityManager->flush();
            $this->addFlash('success', 'Pomyślnie umówiono wizytę');
            return $this->redirectToRoute('index');
        }
        return $this->render('date_of_visit/sign_up.html.twig', [
            'visit' => $visit,
            'form' => $form->createView()
        ]);
    }
}
