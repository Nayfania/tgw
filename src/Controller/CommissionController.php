<?php

namespace App\Controller;

use App\Form\FileType;
use App\Services\CommissionManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CommissionController extends AbstractController
{
    #[Route('/')]
    public function calculate(CommissionManager $commissionManager, Request $request): Response
    {
        $form = $this->createForm(FileType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('file')->getData();
        }

        return $this->render('/commission/calculate.html.twig', [
            'form' => $form,
        ]);
    }
}