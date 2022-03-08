<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Entity\TestResults;
use App\Form\TestResultsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;

class TestResultsController extends AbstractController
{
    /**
     * @Route("/all/tests/{patient}", name="all_tests")
     */
    public function index(Patient $patient): Response
    {
        $repository = $this->getDoctrine()->getRepository(TestResults::class);
        return $this->render('test_results/index.html.twig', [
            'tests' => $repository->findBy(['patient' => $patient])
        ]);
    }

    /**
     * @Route("/test/details/{test}", name="test_details")
     */
    public function details(TestResults $test): Response
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'DejaVu Sans');
        $dompdf = new Dompdf($pdfOptions);
        $repository = $this->getDoctrine()->getRepository(TestResults::class);
        if ($test->getPatient()->getSex() == "mężczyzna") {
            $norm = ["42%-52%", "12.5-18.0", "4.0-10.8", "1.0-4.5", "4.7-6.1"];
        } else {
            $norm = ["37%-47%", "11.5-16.0", "4.0-10.8", "1.0-4.5", "4.2-5.4"];
        }
        $html = $this->renderView('test_results/test.html.twig', [
            'test' => $repository->find($test),
            'patient' => $test->getPatient(),
            'norm' => $norm
        ]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A5', 'portrait');
        $dompdf->render();
        $dompdf->stream("badania.pdf", [
            "Attachment" => false
        ]);
        return new Response('', 200, [
            'Content-Type' => 'application/pdf',
        ]);
    }

    /**
     * @Route("/add/test/results/{patient}", name="add_test_results")
     */
    public function add(Request $request, Patient $patient): Response
    {
        $testResults = new TestResults();
        $form = $this->createForm(TestResultsType::class, $testResults);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $testResults->setPatient($patient);
            $entityManager->persist($testResults);
            $entityManager->flush();
            $this->addFlash('success', 'Pomyślnie dodano wyniki testu');
        }
        return $this->render('test_results/add.html.twig', [
            'form' => $form->createView(),
            'patient' => $patient
        ]);
    }
}
