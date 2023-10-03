<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Form\AuteurType;
use App\Repository\AuteurRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AuteurController extends AbstractController
{
    #[Route('/auteur/creer', name: 'creer_auteur')]
    public function new(ManagerRegistry $doctrine, Request $request): Response
    {
        $em = $doctrine->getManager();

        $post = new Auteur();

        $form = $this->createForm(AuteurType::class, $post);

        $form = $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid())
        {
            $auteur = $form->getData();
            
            $em->persist($auteur);
           
            $em->flush();

            return $this->render('auteur/success.html.twig', ['auteur' => $auteur]);
        
        }
        return $this->renderForm('auteur/new.html.twig', [
            'form' => $form
        ]);
    }
}
