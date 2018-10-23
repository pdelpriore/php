<?php

namespace App\Controller;

use App\Entity\CertaintyLevel;
use App\Form\CertaintyLevelType;
use App\Repository\CertaintyLevelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/certainty/level")
 */
class CertaintyLevelController extends Controller
{
    /**
     * @Route("/", name="certainty_level_index", methods="GET")
     */
    public function index(CertaintyLevelRepository $certaintyLevelRepository): Response
    {
        return $this->render('certainty_level/index.html.twig', ['certainty_levels' => $certaintyLevelRepository->findAll()]);
    }

    /**
     * @Route("/new", name="certainty_level_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $certaintyLevel = new CertaintyLevel();
        $form = $this->createForm(CertaintyLevelType::class, $certaintyLevel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($certaintyLevel);
            $em->flush();

            return $this->redirectToRoute('certainty_level_index');
        }

        return $this->render('certainty_level/new.html.twig', [
            'certainty_level' => $certaintyLevel,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="certainty_level_show", methods="GET")
     */
    public function show(CertaintyLevel $certaintyLevel): Response
    {
        return $this->render('certainty_level/show.html.twig', ['certainty_level' => $certaintyLevel]);
    }

    /**
     * @Route("/{id}/edit", name="certainty_level_edit", methods="GET|POST")
     */
    public function edit(Request $request, CertaintyLevel $certaintyLevel): Response
    {
        $form = $this->createForm(CertaintyLevelType::class, $certaintyLevel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('certainty_level_index', ['id' => $certaintyLevel->getId()]);
        }

        return $this->render('certainty_level/edit.html.twig', [
            'certainty_level' => $certaintyLevel,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="certainty_level_delete", methods="DELETE")
     */
    public function delete(Request $request, CertaintyLevel $certaintyLevel): Response
    {
        if ($this->isCsrfTokenValid('delete'.$certaintyLevel->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($certaintyLevel);
            $em->flush();
        }

        return $this->redirectToRoute('certainty_level_index');
    }
}
