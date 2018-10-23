<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use App\Repository\ClientRepository;
use App\Service\ClientService;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/client")
 */
class ClientController extends Controller
{
    /**
     * @Route("/", name="client_index", methods="GET")
     */
    public function index(ClientRepository $clientRepository): Response
    {
        return $this->render('client/index.html.twig', ['clients' => $clientRepository->findAll()]);
    }

    /**
     * @Route("/new", name="client_new", methods="GET|POST")
     */
    public function new(Request $request, ClientService $clientService, ClientRepository $clientRepository): Response
    {
        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($client);
            $em->flush();

            // A présent que l'ID est défini, on peut uploader l'image avec comme nom de fichier l'ID du client.
            if ($client->getLogo() != null) {
                $client = $clientRepository->findOneBy(array('id' => $client->getId()));
                $client->setLogo($clientService->uploadLogo($client));
                $em->flush();
            }


            return $this->redirectToRoute('client_index');
        }

        return $this->render('client/new.html.twig', [
            'client' => $client,
            'undeletableClient' => [],
            'undeletablePeople' => [],
            'undeletableApplications' => [],
            'form' => $form->createView(),
            'errorsForms' => $form->getErrors(true)
        ]);
    }

    /**
     * @Route("/{id}", name="client_show", methods="GET")
     */
    public function show(Client $client): Response
    {
        return $this->render('client/show.html.twig', ['client' => $client]);
    }

    /**
     * @Route("/{id}/edit", name="client_edit", methods="GET|POST")
     */
    public function edit(Request $request, Client $client, ClientService $clientService, ClientRepository $clientRepository): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        if (!$client) {
            throw $this->createNotFoundException('Aucun client trouvé pour l\'identifiant ' . $client->getId());
        }

        $originalInChargePersons = new ArrayCollection();
        $originalApplications = new ArrayCollection();

        foreach ($client->getInChargePersons() as $inChargePerson) {
            $originalInChargePersons->add($inChargePerson);
        }
        foreach ($client->getApplications() as $application) {
            $originalApplications->add($application);
        }

        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($originalInChargePersons as $inChargePerson) {

                if (false === $client->getInChargePersons()->contains($inChargePerson)) {
                    $inChargePerson->setClient(null);
                    $entityManager->remove($inChargePerson);
                }
            }
            foreach ($originalApplications as $application) {
                if (false === $client->getApplications()->contains($application)) {
                    $application->setClient(null);
                    $entityManager->remove($application);
                }
            }

                $client->setLogo($clientService->uploadLogo($client));

            $this->getDoctrine()
                ->getManager()
                ->flush();
            return $this->redirectToRoute('client_edit', ['id' => $client->getId()]);
        }

        $undeletablePeople = [];
        foreach ($originalInChargePersons as $inChargePerson) {
            if ($inChargePerson->getApplications()->count() > 0
                or $inChargePerson->getHeaders()->count() > 0) {
                array_push($undeletablePeople, $inChargePerson->getId());
            }
        }

        $undeletableApplications = [];
        foreach ($originalApplications as $application) {
            if ($application->getInChargePeople()->count() > 0
                or $application->getHeaders()->count() > 0) {
                array_push($undeletableApplications, $application->getId());
            }
        }

        $undeletableClient = false;
        if ($client->getInChargePersons()->count() > 0
            or $client->getApplications()->count() > 0) {
            $undeletableClient = true;
        }

        return $this->render('client/edit.html.twig', [
            'client' => $client,
            'undeletableClient' => $undeletableClient,
            'undeletablePeople' => $undeletablePeople,
            'undeletableApplications' => $undeletableApplications,
            'form' => $form->createView(),
            'errorsForms' => $form->getErrors(true)
        ]);

    }

    /**
     * @Route("/{id}", name="client_delete", methods="DELETE")
     */
    public function delete(Request $request, Client $client): Response
    {
        if ($this->isCsrfTokenValid('delete' . $client->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($client);
            $em->flush();
        }

        return $this->redirectToRoute('client_index');
    }
}
