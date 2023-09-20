<?php

namespace App\Controller;

use App\Entity\Employeur;
use App\Form\EmployeurType;
use App\Repository\EmployeurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EmployeurController extends AbstractController
{
    #[Route('/employeur', name: 'app_employeur')]
    public function index(EmployeurRepository $employeurRepository): Response
    {
        $employeurs = $employeurRepository->findBy([], ["nom" => "ASC"]);
        return $this->render('employeur/index.html.twig', [
            'employeurs' => $employeurs
        ]);
    }

    #[Route('/admin/employeur/new', name: 'new_employeur')]
    #[Route('/admin/employeur/{id}/edit', name: 'edit_employeur')]
    public function new_edit(Employeur $employeur = null, Request $request, EntityManagerInterface $entityManager): Response
    {
        if(!$employeur){
            $employeur = new Employeur();
        }

        $form = $this->createForm(EmployeurType::class, $employeur);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $employeur = $form->getData();
            
            $entityManager->persist($employeur);

            $entityManager->flush();

            return $this->redirectToRoute('app_employeur');
        }
        
        return $this->render('employeur/new.html.twig', [
            'formAddEmployeur' => $form,
        ]);
    }

    #[Route('/admin/employeur/{id}/delete', name: 'delete_employeur')]
    public function delete(Employeur $employeur, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($employeur);
        $entityManager->flush();

        return  $this->redirectToRoute('app_employeur');
    }

    #[Route('/employeur/{id}', name: 'show_employeur')]
    public function show(Employeur $employeur): Response
    {
        return $this->render('employeur/show.html.twig', [
            'employeur' =>  $employeur
        ]);
    }
}
