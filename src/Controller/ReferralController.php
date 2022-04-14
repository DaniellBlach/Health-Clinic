<?php

namespace App\Controller;

use App\Entity\Referral;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
