<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmployeurController extends AbstractController
{
    #[Route('/employeur', name: 'app_employeur')]
    public function index(): Response
    {
        return $this->render('employeur/index.html.twig', [
            'controller_name' => 'EmployeurController',
        ]);
    }
}
