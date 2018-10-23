<?php

namespace App\Controller;

use App\Entity\CyllenePerson;
use App\Form\CyllenePersonType;
use App\Repository\CyllenePersonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cyllene/person")
 */
class CyllenePersonController extends Controller
{
    /**
     * @Route("/", name="cyllene_person_index", methods="GET")
     */
    public function index(CyllenePersonRepository $cyllenePersonRepository): Response
    {
        return $this->render('cyllene_person/index.html.twig', ['cyllene_people' => $cyllenePersonRepository->findAll()]);
    }

    /**
     * @Route("/new", name="cyllene_person_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $cyllenePerson = new CyllenePerson();
        $form = $this->createForm(CyllenePersonType::class, $cyllenePerson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cyllenePerson);
            $em->flush();

            return $this->redirectToRoute('cyllene_person_index');
        }

        return $this->render('cyllene_person/new.html.twig', [
            'cyllene_person' => $cyllenePerson,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cyllene_person_show", methods="GET")
     */
    public function show(CyllenePerson $cyllenePerson): Response
    {
        return $this->render('cyllene_person/show.html.twig', ['cyllene_person' => $cyllenePerson]);
    }

    /**
     * @Route("/{id}/edit", name="cyllene_person_edit", methods="GET|POST")
     */
    public function edit(Request $request, CyllenePerson $cyllenePerson): Response
    {
        $form = $this->createForm(CyllenePersonType::class, $cyllenePerson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cyllene_person_index', ['id' => $cyllenePerson->getId()]);
        }

        return $this->render('cyllene_person/edit.html.twig', [
            'cyllene_person' => $cyllenePerson,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cyllene_person_delete", methods="DELETE")
     */
    public function delete(Request $request, CyllenePerson $cyllenePerson): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cyllenePerson->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cyllenePerson);
            $em->flush();
        }

        return $this->redirectToRoute('cyllene_person_index');
    }
}
