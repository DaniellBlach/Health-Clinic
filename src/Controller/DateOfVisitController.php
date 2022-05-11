<?php

namespace App\Controller;

use App\Entity\DateOfVisit;
use App\Form\DateOfVisitType;
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

    /**
     * @Route("/add/visits", name="add_visits")
     */
    public function addVisits(Request $request): Response
    {
        $form = $this->createForm(DateOfVisitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $date = $form->get('date')->getData();
            $doctor = $form->get('Doctor')->getData();
            $startTime = $form->get('startTime')->getData();
            $endTime = $form->get('endTime')->getData();
            $howManyWorkTime = ($endTime->format("H") * 60 + $endTime->format("i")) - ($startTime->format("H") * 60 + $startTime->format("i"));
            $howManyVisits = floor($howManyWorkTime / 20);
            if ($form->get('date')->getData() < date_create(date("d-m-Y"))) {
                $this->addFlash('error', 'Podano błędną datę');
            } elseif ($howManyVisits > 0) {
                for ($i=0; $i < $howManyVisits; $i++) {
                    $this->createVisit($doctor, $date, $startTime);
                    date_add($startTime, date_interval_create_from_date_string("20 minutes"));
                }
                $this->addFlash('success', 'Pomyślnie dodano terminy wizyt!');
            } else {
                $this->addFlash('error', 'Podano błędne godziny');
            }
        }
        return $this->render('date_of_visit/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function createVisit($doctor, $date, $startTime)
    {
        $visit = new DateOfVisit();
        $visit->setDoctor($doctor);
        $visit->setDate($date);
        $visit->setTime($startTime);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($visit);
        $entityManager->flush();
    }
}
