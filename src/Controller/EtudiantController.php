<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Form\EtudiantType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/etudiant")
 */
class EtudiantController extends Controller
{
    /**
     * @Route("/", name="etudiant_index", methods="GET")
     */
    public function index(): Response
    {
        $this->secured2();
        $etudiants = $this->getDoctrine()
            ->getRepository(Etudiant::class)
            ->findAll();

        return $this->render('etudiant/index.html.twig', ['etudiants' => $etudiants]);
        
    }

    /**
     * @Route("/new", name="etudiant_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        if($this->secured('ROLE_PROF') or $this->secured('ROLE_ADMIN')){
        $etudiant = new Etudiant();
        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($etudiant);
            $em->flush();

            return $this->redirectToRoute('etudiant_index');
        }

        return $this->render('etudiant/new.html.twig', [
            'etudiant' => $etudiant,
            'form' => $form->createView(),
        ]);
        }
    }

    /**
     * @Route("/{id}", name="etudiant_show", methods="GET")
     */
    public function show(Etudiant $etudiant): Response
    {
        $this->secured2();
        return $this->render('etudiant/show.html.twig', ['etudiant' => $etudiant]);
    }

    /**
     * @Route("/{id}/edit", name="etudiant_edit", methods="GET|POST")
     */
    public function edit(Request $request, Etudiant $etudiant): Response
    {   if($this->secured('ROLE_ADMIN') or $this->secured('ROLE_PROF')){
        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('etudiant_edit', ['id' => $etudiant->getId()]);
        }

        return $this->render('etudiant/edit.html.twig', [
            'etudiant' => $etudiant,
            'form' => $form->createView(),
        ]);
    }}
public function secured($role)
    {
        if (!$this->get('security.authorization_checker')->isGranted($role)) {
            throw $this->createAccessDeniedException('GET OUT!');
            return FALSE;
        }
        else return TRUE;}

        public function secured2()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');}
    /**
     * @Route("/{id}", name="etudiant_delete", methods="DELETE")
     */
    public function delete(Request $request, Etudiant $etudiant): Response
    {
        if($this->secured('ROLE_PROF')){
        if ($this->isCsrfTokenValid('delete'.$etudiant->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($etudiant);
            $em->flush();
        }

        return $this->redirectToRoute('etudiant_index');
    }
}


}
