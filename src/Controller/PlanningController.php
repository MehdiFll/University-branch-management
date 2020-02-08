<?php

namespace App\Controller;

use App\Entity\Planning;
use App\Form\PlanningType;
use App\Repository\PlanningRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/planning")
 */
class PlanningController extends Controller
{
    /**
     * @Route("/", name="planning_index", methods="GET")
     */
    public function index(PlanningRepository $planningRepository): Response
    {
        if($this->secured()){
        return $this->render('planning/index.html.twig', ['plannings' => $planningRepository->findAll()]);
        }
    }

    /**
     * @Route("/etudiant/{id}", name="planning_index2", methods="GET")
     */
    public function index2(PlanningRepository $planningRepository, $id): Response
    {
        $this->secured2();
        return $this->render('planning/index2.html.twig', ['plannings' => $planningRepository->findBy(['filiere' => $id])]);
        
    }


    /**
     * @Route("/{date_debut}/new", name="planning_new", methods="GET|POST")
     *
     */
    public function new(Request $request, $date_debut): Response
    {
        if($this->secured()){
        $planning = new Planning();
        $date_debut=$date_debut." 00:00:00";
        $planning->setDateDebut($date_debut);
        $planning->setDateFin($date_debut);
        $form = $this->createForm(PlanningType::class, $planning);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($planning);
            $em->flush();

            return $this->redirectToRoute('planning_index');
        }
        
        return $this->render('planning/new.html.twig', [
            'planning' => $planning,
            'form' => $form->createView(),
        ]);
        }
    }

    /**
     * @Route("/{id}", name="planning_show", methods="GET")
     */
    public function show(Planning $planning): Response
    {
        if($this->secured()){
        return $this->render('planning/show.html.twig', ['planning' => $planning]);
        }
    }

    /**
     * @Route("/{id}/edit", name="planning_edit", methods="GET|POST")
     */
    public function edit(Request $request, Planning $planning): Response
    {
        if($this->secured()){
        $form = $this->createForm(PlanningType::class, $planning);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('planning_edit', ['id' => $planning->getId()]);
        }

        return $this->render('planning/edit.html.twig', [
            'planning' => $planning,
            'form' => $form->createView(),
        ]);
        }
    }

    /**
     * @Route("/{id}", name="planning_delete", methods="DELETE")
     */
    public function delete(Request $request, Planning $planning): Response
    {
        if($this->secured()){
        if ($this->isCsrfTokenValid('delete'.$planning->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($planning);
            $em->flush();
        }

        return $this->redirectToRoute('planning_index');
    }
    }
    public function secured2()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');}

        public function secured()
        {
            if (!$this->get('security.authorization_checker')->isGranted('ROLE_PROF')) {
                throw $this->createAccessDeniedException('GET OUT!');
                return FALSE;
            }
            else return TRUE;}
}
