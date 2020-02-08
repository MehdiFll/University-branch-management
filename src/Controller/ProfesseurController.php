<?php

namespace App\Controller;

use App\Entity\Professeur;
use App\Form\ProfesseurType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/professeur")
 */
class ProfesseurController extends Controller
{
    /**
     * @Route("/", name="professeur_index", methods="GET")
     */

 
    public function index(): Response
    {   
        if($this->secured()){
        $professeurs = $this->getDoctrine()
            ->getRepository(Professeur::class)
            ->findAll();

        return $this->render('professeur/index.html.twig', ['professeurs' => $professeurs]);}
    }

    /**
     * @Route("/new", name="professeur_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        if($this->secured()){
        $professeur = new Professeur();
        $form = $this->createForm(ProfesseurType::class, $professeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($professeur);
            $em->flush();

            return $this->redirectToRoute('professeur_index');
        }

        return $this->render('professeur/new.html.twig', [
            'professeur' => $professeur,
            'form' => $form->createView(),
        ]);
    }
    }
    /**
     * @Route("/{id}", name="professeur_show", methods="GET")
     */
    public function show(Professeur $professeur): Response
    {
        if($this->secured()){
        return $this->render('professeur/show.html.twig', ['professeur' => $professeur]);
    }
}

    /**
     * @Route("/{id}/edit", name="professeur_edit", methods="GET|POST")
     */
    public function edit(Request $request, Professeur $professeur): Response
    {
        if($this->secured()){
        $form = $this->createForm(ProfesseurType::class, $professeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('professeur_edit', ['id' => $professeur->getId()]);
        }

        return $this->render('professeur/edit.html.twig', [
            'professeur' => $professeur,
            'form' => $form->createView(),
        ]);
    }
    }
    /**
     * @Route("/{id}", name="professeur_delete", methods="DELETE")
     */
    public function delete(Request $request, Professeur $professeur): Response
    {
        if($this->secured()){
        if ($this->isCsrfTokenValid('delete'.$professeur->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($professeur);
            $em->flush();
        }

        return $this->redirectToRoute('professeur_index');
    }

    }
    public function secured()
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_PROF') or $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return TRUE;
        }
        else { return FALSE;
    throw $this->createAccessDeniedException('GET OUT!');}}
        
}
