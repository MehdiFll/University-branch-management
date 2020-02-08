<?php

namespace App\Controller;

use App\Entity\Filiere;
use App\Form\FiliereType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/filiere")
 */
class FiliereController extends Controller
{
    /**
     * @Route("/", name="filiere_index", methods="GET")
     */
    public function index(): Response
    {
        if($this->secured()){
        $filieres = $this->getDoctrine()
            ->getRepository(Filiere::class)
            ->findAll();

        return $this->render('filiere/index.html.twig', ['filieres' => $filieres]);
    }
    }
    /**
     * @Route("/new", name="filiere_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    { if($this->secured()){
        $filiere = new Filiere();
        $form = $this->createForm(FiliereType::class, $filiere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($filiere);
            $em->flush();

            return $this->redirectToRoute('filiere_index');
        }

        return $this->render('filiere/new.html.twig', [
            'filiere' => $filiere,
            'form' => $form->createView(),
        ]);
    }}

    /**
     * @Route("/{id}", name="filiere_show", methods="GET")
     */
    public function show(Filiere $filiere): Response
    { if($this->secured()){
        return $this->render('filiere/show.html.twig', ['filiere' => $filiere]);}
    }

    /**
     * @Route("/{id}/edit", name="filiere_edit", methods="GET|POST")
     */
    public function edit(Request $request, Filiere $filiere): Response
    {   if($this->secured()){
        $form = $this->createForm(FiliereType::class, $filiere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('filiere_edit', ['id' => $filiere->getId()]);
        }

        return $this->render('filiere/edit.html.twig', [
            'filiere' => $filiere,
            'form' => $form->createView(),
        ]);
    }}

    /**
     * @Route("/{id}", name="filiere_delete", methods="DELETE")
     */
    public function delete(Request $request, Filiere $filiere): Response
    {
        if($this->secured()){
        if ($this->isCsrfTokenValid('delete'.$filiere->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($filiere);
            $em->flush();
        }

        return $this->redirectToRoute('filiere_index');}
    }

    public function secured()
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_PROF')) {
            throw $this->createAccessDeniedException('GET OUT!');
            return FALSE;
        }
        else return TRUE;}
}
