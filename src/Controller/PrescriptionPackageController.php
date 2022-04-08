<?php

namespace App\Controller;

use App\Entity\PrescriptionPackage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
            'prescriptions'=>$prescriptions
        ]);
    }
}
