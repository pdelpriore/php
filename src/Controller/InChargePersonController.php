<?php

namespace App\Controller;

use App\Entity\Application;
use App\Entity\InChargePerson;
use App\Form\InChargePersonType;
use App\Repository\ApplicationRepository;
use App\Repository\InChargePersonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/in/charge/person")
 */
class InChargePersonController extends Controller
{
    /**
     * @Route("/", name="in_charge_person_index", methods="GET")
     */
    public function index(InChargePersonRepository $inChargePersonRepository): Response
    {
        return $this->render('in_charge_person/index.html.twig', ['in_charge_people' => $inChargePersonRepository->findAll()]);
    }

    /**
     * @Route("/new", name="in_charge_person_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $inChargePerson = new InChargePerson();
        $form = $this->createForm(InChargePersonType::class, $inChargePerson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($inChargePerson);
            $em->flush();

            return $this->redirectToRoute('in_charge_person_index');
        }

        return $this->render('in_charge_person/new.html.twig', [
            'in_charge_person' => $inChargePerson,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="in_charge_person_show", methods="GET")
     */
    public function show(InChargePerson $inChargePerson): Response
    {
        return $this->render('in_charge_person/show.html.twig', ['in_charge_person' => $inChargePerson]);
    }

    /**
     * @Route("/{id}/edit", name="in_charge_person_edit", methods="GET|POST")
     */
    public function edit(Request $request, InChargePerson $inChargePerson, ApplicationRepository $applicationRepository): Response
    {
        $applicationsList = [];
        $applicationsList['followed'] = [];
        $applicationsList['otherOnes'] = [];

        $applicationsPerson = [];
        foreach ($inChargePerson->getApplications() as $application) {
            $applicationsPerson[] = $application->getId();
        }

        if ($request->isMethod('POST')) {
            $post = $request->request->all();

            $inChargePerson->removeEachApplication();
            if (isset($post['followed'])) {
                foreach ($post['followed'] as $followedId) {
                    $inChargePerson->addApplication($applicationRepository->findOneBy(array('id' => $followedId)));
                }
            }

            $this->getDoctrine()
                ->getManager()
                ->flush();
            return $this->redirectToRoute('in_charge_person_edit', ['id' => $inChargePerson->getId()]);
        }


        $applications = $applicationRepository->findAll();
        foreach ($applications as $application) {
            if ($application->getClient() === $inChargePerson->getClient()) {
                if (in_array($application->getId(), $applicationsPerson)) {
                    array_push($applicationsList['followed'], $application);
                }
                else {
                    array_push($applicationsList['otherOnes'], $application);
                }
            }
        }


        return $this->render('in_charge_person/edit.html.twig', [
            'in_charge_person' => $inChargePerson,
            'followedApplications' => $applicationsList['followed'],
            'otherApplications' => $applicationsList['otherOnes'],
        ]);
    }

    /**
     * @Route("/{id}", name="in_charge_person_delete", methods="DELETE")
     */
    public function delete(Request $request, InChargePerson $inChargePerson): Response
    {
        if ($this->isCsrfTokenValid('delete'.$inChargePerson->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($inChargePerson);
            $em->flush();
        }

        return $this->redirectToRoute('in_charge_person_index');
    }
}
