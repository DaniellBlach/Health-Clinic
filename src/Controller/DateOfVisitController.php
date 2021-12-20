<?php

namespace App\Controller;

use App\Entity\DateOfVisit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DateOfVisitController extends AbstractController
{
    /**
     * @Route("/visits", name="visits")
     */
    public function index(): Response
    {
        $repository = $this->getDoctrine()->getRepository(DateOfVisit::class);
        return $this->render('date_of_visit/index.html.twig', [
            'visits'=>$repository->findAll()
        ]);
    }
}
