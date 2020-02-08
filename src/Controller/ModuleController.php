<?php

namespace App\Controller;

use App\Entity\Module;
use App\Form\ModuleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/module")
 */
class ModuleController extends Controller
{
    /**
     * @Route("/", name="module_index", methods="GET")
     */
    public function index(): Response
    {
        $this->secured2();
        $modules = $this->getDoctrine()
            ->getRepository(Module::class)
            ->findAll();

        return $this->render('module/index.html.twig', ['modules' => $modules]);
    
}

    /**
     * @Route("/new", name="module_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        if($this->secured('ROLE_PROF')){
        $module = new Module();
        $form = $this->createForm(ModuleType::class, $module);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($module);
            $em->flush();

            return $this->redirectToRoute('module_index');
        }

        return $this->render('module/new.html.twig', [
            'module' => $module,
            'form' => $form->createView(),
        ]);
    }}

    /**
     * @Route("/{id}", name="module_show", methods="GET")
     */
    public function show(Module $module): Response
    {
        if($this->secured('ROLE_PROF')){
        return $this->render('module/show.html.twig', ['module' => $module]);}
    }

    /**
     * @Route("/{id}/edit", name="module_edit", methods="GET|POST")
     */
    public function edit(Request $request, Module $module): Response
    {
        if($this->secured('ROLE_PROF')){
        $form = $this->createForm(ModuleType::class, $module);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('module_edit', ['id' => $module->getId()]);
        }

        return $this->render('module/edit.html.twig', [
            'module' => $module,
            'form' => $form->createView(),
        ]);
    }}

    /**
     * @Route("/{id}", name="module_delete", methods="DELETE")
     */
    public function delete(Request $request, Module $module): Response
    {
        if($this->secured('ROLE_PROF')){
        if ($this->isCsrfTokenValid('delete'.$module->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($module);
            $em->flush();
        }

        return $this->redirectToRoute('module_index');
    }
    }
     public function secured($role)
    {
        if (!$this->get('security.authorization_checker')->isGranted($role)) {
            throw $this->createAccessDeniedException('GET OUT!');
            return FALSE;
        }
        else return TRUE;}

        public function secured2()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
    
    }
}
