<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Entity\TestResults;
use App\Form\TestResultsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestResultsController extends AbstractController
{
    /**
     * @Route("/add/test/results/{patient}", name="add_test_results")
     */
    public function add(Request $request,Patient $patient): Response
    {
        $testResults = new TestResults();
        $form = $this->createForm(TestResultsType::class, $testResults);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager=$this->getDoctrine()->getManager();
            $testResults->setPatient($patient);
            $entityManager->persist($testResults);
            $entityManager->flush();
            $this->addFlash('success', 'Pomyślnie dodano wyniki testu');
        }
        return $this->render('test_results/add.html.twig', [
            'form' => $form->createView(),
            'patient'=>$patient
        ]);
    }
}
