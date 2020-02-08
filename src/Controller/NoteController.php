<?php

namespace App\Controller;

use App\Entity\Note;
use App\Form\NoteType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/note")
 */
class NoteController extends Controller
{
    /**
     * @Route("/", name="note_index", methods="GET")
     */
    public function index(): Response
    {
        $this->secured2();
        $notes = $this->getDoctrine()
            ->getRepository(Note::class)
            ->findAll();

        return $this->render('note/index.html.twig', ['notes' => $notes]);
        
    }

    /**
     * @Route("/new", name="note_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        if($this->secured()){
        $note = new Note();
        $form = $this->createForm(NoteType::class, $note);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($note);
            $em->flush();

            return $this->redirectToRoute('note_index');
        }

        return $this->render('note/new.html.twig', [
            'note' => $note,
            'form' => $form->createView(),
        ]);
        }
    }

    /**
     * @Route("/{id}", name="note_show", methods="GET")
     */
    public function show(Note $note): Response
    {
        $this->secured2();
        return $this->render('note/show.html.twig', ['note' => $note]);
    }

    /**
     * @Route("/{id}/edit", name="note_edit", methods="GET|POST")
     */
    public function edit(Request $request, Note $note): Response
    {
        if($this->secured()){
        $form = $this->createForm(NoteType::class, $note);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('note_edit', ['id' => $note->getId()]);
        }

        return $this->render('note/edit.html.twig', [
            'note' => $note,
            'form' => $form->createView(),
        ]);
        }
    }

    /**
     * @Route("/{id}", name="note_delete", methods="DELETE")
     */
    public function delete(Request $request, Note $note): Response
    {
        if($this->secured()){
        if ($this->isCsrfTokenValid('delete'.$note->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($note);
            $em->flush();
        }

        return $this->redirectToRoute('note_index');}
    }
    public function secured()
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_PROF')) {
            throw $this->createAccessDeniedException('GET OUT!');
            return FALSE;
        }
        else return TRUE;}

        public function secured2()
        {
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');}
}
