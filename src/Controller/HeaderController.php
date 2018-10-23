<?php

namespace App\Controller;

use App\Entity\ActivityGroup;
use App\Entity\Billing;
use App\Entity\Detail;
use App\Entity\Header;
use App\Entity\InChargePerson;
use App\Entity\Step;
use App\Form\HeaderType;
use App\Form\HeaderVersionType;
use App\Repository\BillingRepository;
use App\Repository\CertaintyLevelRepository;
use App\Repository\HeaderRepository;
use App\Repository\ParameterRepository;
use App\Repository\ProfilRepository;
use App\Repository\StepRepository;
use App\Service\ApplicationService;
use App\Service\DetailService;
use App\Service\WebDevisService;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Spipu\Html2Pdf\Html2Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\Packages;
use Symfony\Component\Asset\PathPackage;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;
use Symfony\Component\Asset\VersionStrategy\StaticVersionStrategy;
use Symfony\Component\Asset\UrlPackage;
use Symfony\Component\Asset\Context\RequestStackContext;
use Symfony\Component\Asset\VersionStrategy\VersionStrategyInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;
use App\Service\HeaderService;
use App\Service\GroupService;

/**
 * @Route("/header")
 */
class HeaderController extends Controller
{
    /**
     * @Route("/", name="header_index")
     */
    public function index(Request $request,
                          HeaderRepository $headerRepository,
                          HeaderService $headerService,
                          StepRepository $stepRepository,
                          BillingRepository $billingRepository  ): Response
    {
        $filters = [];
        $billings = $this->getDoctrine()->getRepository(Billing::class)->findAll();
        $filters['billings'] = $billings;
        $steps = $this->getDoctrine()->getRepository(Step::class)->findAll();
        $filters['steps'] = $steps;

        if ($request->isMethod('POST')) {
            $post = $request->request->all();

            $filters = array_merge($post, $filters);

        } else {

            $stepDefault = $stepRepository->findOneBy(array(
                'stepDefault' => true
            ));

            $billDefault = $billingRepository->findOneBy(array(
                'billDefault' => true
            ));

            if($request->query->get('step') != null) {
                $filters['stepSelected'] = $request->query->get('step');   // Non envoyé
            } else {
                $filters['stepSelected'] = $stepDefault->getNumber();   // Non envoyé
            }

            $filters['billingSelected'] = $billDefault->getId();// Projet
        }

        $headerList = [];

                $headerAll = $headerRepository->findElement($filters['billingSelected']);

                foreach ($headerAll as $header) {

                    if($headerService->getStatus($header) == $filters['stepSelected']) {

                        $headerList[] = [
                            $header->getId(),
                            $header->getTitle(),
                            $headerService->getReducedString($header->getApplication()->getName(), 30),
                            $headerService->getReducedString($header->getDescription()),
                            $headerService->getTotalDays($header),
                            $headerService->getTotalPrice($header),
                            $header->getDeletedOn(),
                            $header->getCyllenePerson()->getName(),
                            $header->getCreatedOn(),
                            $headerService->getStatus($header),
                        ];
                    }
                }

        return $this->render('header/index.html.twig', [
            'headers' => $headerList,
            'filters' => $filters,
        ]);
    }

    /**
     * @Route("/new", name="header_new", methods="GET|POST")
     */
    public function new(Request $request,
                        HeaderService $headerService,
                        DetailService $detailService,
                        GroupService $groupService,
                        ProfilRepository $profilRepository,
                        CertaintyLevelRepository $certaintyLevelRepository,
                        WebDevisService $webDevisService): Response
    {
        $header = new Header();
        $header->setRedmineId(0);
        $form = $this->createForm(HeaderType::class, $header);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $header->setUpdatedOn(new \DateTime());
            $header->setEstimateVersion(1.0);
            $header->setTitle($headerService->setTitleHeader($header));
            $details = $header->getDetails();

            // Quel est le groupe "Référent" (son ratio et son nombre de jours total sur le devis) ?
            $activityGroupRepository = $this->getDoctrine()->getRepository(ActivityGroup::class);
            $referent = $activityGroupRepository->findOneBy(array('referent' => true));
            $referentTotalDays = $groupService->totalDaysEstimatedGroup($referent, $header);
            $referentRate = $referent->getRate() / 100;

            $activityGroups = $activityGroupRepository->findAll();


            foreach ($details as $detail) {
                if ($detail->getActivityGroup() != $referent && $detail->getAutomatic() && $groupService->getDetailRate($detail) !== null) {

                    $detail->setEstimatedDays($referentTotalDays * $groupService->getDetailRate($detail) / $referentRate);
                }
                $detail->setEstimatedDays($detailService->roundingDays($detail->getEstimatedDays()));
                $detail->setLowDays($detailService->lowDays($detail));
                $detail->setHighDays($detailService->highDays($detail));
                $detail->setCalculatedDays($detailService->calculatedDays($detail));
                if ($detail->getAutomatic()) {
                    $detail = $detailService->floor($detail);
                }
                $detail->setDailyCost($detailService->getDailyCost($detail));
                $detail->setPrice($detailService->calculatePrice($detail));
                $detail->setCreatedOn(new \DateTime());
                $detail->setUpdatedOn(new \DateTime());
            }

            $create_description = $webDevisService->getParameter('CREATE DESCRIPTION');
            $header->setRevision($create_description != null ? $create_description : 'Création du Devis');


            $em = $this->getDoctrine()->getManager();
            $em->persist($header);
            $em->flush();

            return $this->redirectToRoute('index');
        }

        $groups = [];
        $groupsRepository = $this->getDoctrine()->getRepository(ActivityGroup::class);
        $groupsGlobal = $groupsRepository->findAll();

        $profilDefault = $profilRepository->findOneBy(array('default_selected' => true));

        $certaintyLevelDefault = $certaintyLevelRepository->findOneBy(array('rate' => 1));

        foreach ($groupsGlobal as $groupGlobal) {
            $groups[] = $groupGlobal->getSerialNumber();

            if ($groupGlobal->getAutomatic()) {
                $activities = $groupGlobal->getActivities();
                foreach ($activities as $activity) {
                    $detail = new Detail();
                    $detail->setAutomatic(true);
                    $detail->setEstimatedDays(0);
                    $detail->setActivityGroup($groupGlobal);
                    $detail->setDescription($activity->getName());
                    $detail->setProfil($activity->getProfil());
                    $detail->setCertaintyLevel($certaintyLevelDefault);
                    $header->addDetail($detail);
                }
                $form->get('details')->setData($header->getDetails());
            }
        }

        $taskLine = $webDevisService->getParameter('TASK_LINK');
        $taskLine = $taskLine != null ? $taskLine : 'https://recette.cetsi.fr/issues/';

        $status = $headerService->getStatus($header);

        return $this->render('header/new.html.twig', [
            'header' => $header,
            'groups' => $groups,
            'groupsGlobal' => $groupsGlobal,
            'profilDefault' => $profilDefault->getName(),
            'certaintyLevelDefault' => $certaintyLevelDefault->getName(),
            'taskLine' => $taskLine,
            'status' => $status,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="header_show", methods="GET")
     */
    public function show(Request $request,
                         Header $header,
                         HeaderService $headerService,
                         DetailService $detailService,
                         GroupService $groupService,
                         ProfilRepository $profilRepository,
                         CertaintyLevelRepository $certaintyLevelRepository): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $header = $entityManager->getRepository(Header::class)->find($header);

        if (!$header) {
            throw $this->createNotFoundException('Pas de devis trouvé pour l\'identifiant ' . $header->getId());
        }

        $originalDetails = new ArrayCollection();
        foreach ($header->getDetails() as $detail) {
            $originalDetails->add($detail);
        }

        $form = $this->createForm(HeaderType::class, $header);
        $form->handleRequest($request);

        $groups = [];
        $groupsRepository = $this->getDoctrine()->getRepository(ActivityGroup::class);
        $groupsGlobal = $groupsRepository->findAll();
        foreach ($groupsGlobal as $groupGlobal) {
            $groups[] = $groupGlobal->serial_number;
        }

        $profilDefault = $profilRepository->findOneBy(array('default_selected' => true));

        $certaintyLevelDefault = $certaintyLevelRepository->findOneBy(array('rate' => 1));

        return $this->render('header/show.html.twig', [
            'header' => $header,
            'groups' => $groups,
            'groupsGlobal' => $groupsGlobal,
            'profilDefault' => $profilDefault->getName(),
            'certaintyLevelDefault' => $certaintyLevelDefault->getName(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="header_edit", methods="GET|POST")
     */
    public function edit(Request $request,
                         Header $header,
                         HeaderService $headerService,
                         DetailService $detailService,
                         GroupService $groupService,
                         ProfilRepository $profilRepository,
                         CertaintyLevelRepository $certaintyLevelRepository,
                         WebDevisService $webDevisService): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $header = $entityManager->getRepository(Header::class)->find($header);

        if (!$header) {
            throw $this->createNotFoundException('Pas de devis trouvé pour l\'identifiant ' . $header->getId());
        }

        $originalDetails = new ArrayCollection();
        foreach ($header->getDetails() as $detail) {
            $originalDetails->add($detail);
        }

        $form = $this->createForm(HeaderType::class, $header);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($originalDetails as $detail) {
                if (false === $header->getDetails()->contains($detail)) {
                    $detail->setHeader(null);
                    $entityManager->remove($detail);
                }
            }

            $header->setUpdatedOn(new \DateTime());
            $header->setTitle($headerService->setTitleHeader($header));

            $activityGroupRepository = $this->getDoctrine()->getRepository(ActivityGroup::class);
            $referent = $activityGroupRepository->findOneBy(array('referent' => true));
            $referentTotalDays = $groupService->totalDaysEstimatedGroup($referent, $header);
            $referentRate = $referent->getRate() / 100;

            $details = $header->getDetails();
            foreach ($details as $detail) {

                if ($detail->getActivityGroup() != $referent && $detail->getAutomatic() && $groupService->getDetailRate($detail) !== null) {

                    $detail->setEstimatedDays($referentTotalDays * $groupService->getDetailRate($detail) / $referentRate);
                }

                $detail->setEstimatedDays($detailService->roundingDays($detail->getEstimatedDays()));
                $detail->setLowDays($detailService->lowDays($detail));
                $detail->setHighDays($detailService->highDays($detail));
                $detail->setCalculatedDays($detailService->calculatedDays($detail));
                if ($detail->getAutomatic()) {
                    $detail = $detailService->floor($detail);
                }
                $detail->setDailyCost($detailService->getDailyCost($detail));
                $detail->setPrice($detailService->calculatePrice($detail));
                $detail->setUpdatedOn(new \DateTime());
            }

//            $header->setRevision('Modifcation');

            $this->getDoctrine()
                ->getManager()
                ->flush();
            return $this->redirectToRoute('header_edit', ['id' => $header->getId()]);
        }

        $groups = [];
        $groupsRepository = $this->getDoctrine()->getRepository(ActivityGroup::class);
        $groupsGlobal = $groupsRepository->findAll();
        foreach ($groupsGlobal as $groupGlobal) {
            $groups[] = $groupGlobal->serial_number;
        }

        $profilDefault = $profilRepository->findOneBy(array('default_selected' => true));

        $certaintyLevelDefault = $certaintyLevelRepository->findOneBy(array('rate' => 1));

        $taskLine = $webDevisService->getParameter('TASK_LINK');
        $taskLine = $taskLine != null ? $taskLine : 'https://recette.cetsi.fr/issues/';

        $status = $headerService->getStatus($header);

        return $this->render('header/edit.html.twig', [
            'header' => $header,
            'groups' => $groups,
            'groupsGlobal' => $groupsGlobal,
            'profilDefault' => $profilDefault->getName(),
            'certaintyLevelDefault' => $certaintyLevelDefault->getName(),
            'taskLine' => $taskLine,
            'status' => $status,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name="header_delete", methods="GET|DELETE")
     */
    public function delete(Request $request, Header $header): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $header = $entityManager->getRepository(Header::class)->find($header);

        $header->setDeletedOn(new \DateTime());

        $this->getDoctrine()
            ->getManager()
            ->flush();

        return $this->redirectToRoute('index');
    }

    /**
     * @Route("/{id}/reactivate", name="header_reactivate", methods="GET|REACTIVATE")
     */
    public function reactivate(Request $request,
                               Header $header): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $header = $entityManager->getRepository(Header::class)->find($header);

        $header->setDeletedOn(null);

        $this->getDoctrine()
            ->getManager()
            ->flush();

        return $this->redirectToRoute('index');
    }

    /**
     * @Route("/{id}/send", name="header_send", methods="GET|SEND")
     */
    public function send(Request $request, Header $header): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $header = $entityManager->getRepository(Header::class)->find($header);

        $header->setSentOn(new \DateTime());

        $this->getDoctrine()
            ->getManager()
            ->flush();

        return $this->redirectToRoute('header_pdf', [
            'id' => $header->getId()
        ]);
    }

    /**
     * @Route("/{id}/step4", name="header_step4", methods="GET|SEND")
     */
    public function step4(Request $request, Header $header): Response
    {
        return $this->redirectToRoute('index', array('step' => 4));
    }

    /**
     * @Route("/{id}/refuse", name="header_refuse", methods="GET|REFUSE")
     */
    public function refuse(Request $request, Header $header): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $header = $entityManager->getRepository(Header::class)->find($header);

        $header->setRefusedOn(new \DateTime());

        $this->getDoctrine()
            ->getManager()
            ->flush();

        return $this->redirectToRoute('index', array('step' => 6));
    }

    /**
     * @Route("/{id}/accept", name="header_accept", methods="GET")
     */
    public function accept(Request $request, Header $header): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $header = $entityManager->getRepository(Header::class)->find($header);

        $header->setAgreedOn(new \DateTime());

        $this->getDoctrine()
            ->getManager()
            ->flush();

        return $this->redirectToRoute('index', array('step'=>5) );

    }

    /**
     * @Route("/{id}/version", name="header_version", methods="GET|POST")
     */
    public function version(Request $request, Header $header): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        if ($request->isMethod('POST')) {
            $header->setRefusedOn(new \DateTime());
            $old_header = $header;

            $this->getDoctrine()
                ->getManager()
                ->flush();

            $post = $request->request->all();
            $revision = $post['revision'];

            $new_version = (string)((int)$old_header->getEstimateVersion()+1);
            $new_header = new Header();
            $new_header->setDescription($old_header->getDescription());
            $new_header->setTitle($old_header->getTitle());
            $new_header->setApplicationVersion($old_header->getApplicationVersion());
            $new_header->setRedmineId($old_header->getRedmineId());
            $new_header->setCreatedOn($old_header->getCreatedOn());
            $new_header->setCyllenePerson($old_header->getCyllenePerson());
            $new_header->setApplication($old_header->getApplication());
            $new_header->setInChargePerson($old_header->getInChargePerson());
            $new_header->setBilling($old_header->getBilling());
            $new_header->setEstimateVersion($new_version);
            $new_header->setUpdatedOn(new \DateTime());
            $new_header->setSentOn(null);
            $new_header->setRefusedOn(null);
            $new_header->setRevision($revision);
            $new_header->addEachDetail($old_header->getDetails());

            $entityManager->persist($new_header);
            $entityManager->flush();

            return $this->redirectToRoute('index');

        } else {

            $revision = '';

            return $this->render('header/version.html.twig', [
                'header' => $header,
                'revision' => $revision,
            ]);
        }

    }

    /**
     * @Route("/{id}/deliver", name="header_deliver", methods="GET|DELIVER")
     */
    public function deliver(Request $request, Header $header): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $header = $entityManager->getRepository(Header::class)->find($header);

        $header->setDeliveredOn(new \DateTime());

        $this->getDoctrine()
            ->getManager()
            ->flush();

        return $this->redirectToRoute('index', array('step' => 7));
    }

    /**
     * @Route("/{id}/bill", name="header_bill", methods="GET|BILL")
     */
    public function bill(Request $request, Header $header): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $header = $entityManager->getRepository(Header::class)->find($header);

        $header->setBilledOn(new \DateTime());

        $this->getDoctrine()
            ->getManager()
            ->flush();

        return $this->redirectToRoute('index', array('step' => 8));
    }

    /**
     * @Route("/{id}/pdf", name="header_pdf", methods="GET")
     */
    public function pdfGeneration(Header $header,
                              Request $request,
                              WebDevisService $webDevisService)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $header = $entityManager->getRepository(Header::class)->find($header);

        if (!$header) {
            throw $this->createNotFoundException('Pas de devis trouvé pour l\'identifiant ' . $header->getId());
        }

        $form = $this->createForm(HeaderType::class, $header);
        $form->handleRequest($request);

        $snappy = $this->get('knp_snappy.pdf');

        $url = __DIR__ . '/public';
        $path = str_replace("\\", "/", $url);
        $pathImg = str_replace("/src/Controller", "", $path);

        $details = $header->getDetails();

        $groups = [];
        $groupsRepository = $this->getDoctrine()->getRepository(ActivityGroup::class);
        $groupsGlobal = $groupsRepository->findAll();
        foreach ($groupsGlobal as $groupGlobal) {
            $groups[] = $groupGlobal->serial_number;
        }

        $people = [];
        $inChargePeople = $header->getApplication()->getInChargePeople();
        foreach ($inChargePeople as $person) {
            $people[] = $person;
        }

        $revisions = [];
        $headerRepository = $this->getDoctrine()->getRepository(Header::class);
        $versions = $headerRepository->findAllRevisions($header->getTitle());
        foreach ($versions as $version) {
            $revisions[] = $version;
        }


        $manager_name = $webDevisService->getParameter('MANAGER_NAME');
        $manager_name = $manager_name != null ? $manager_name : 'Daniel DOS PRAZERES';

        $manager_function = $webDevisService->getParameter('MANAGER_FUNCTION');
        $manager_function = $manager_function != null ? $manager_function : 'Cyllène - Software Factory';

        $sales_rep_name = $webDevisService->getParameter('SALES_REP_NAME');
        $sales_rep_name = $sales_rep_name != null ? $sales_rep_name : 'Cynthia BAYOU';

        $sales_rep_department = $webDevisService->getParameter('SALES_REP_DEPT');
        $sales_rep_department = $sales_rep_department != null ? $sales_rep_department : 'Cyllène - Software Factory';

        $options = [
            'no-outline' => true,
            'encoding' => 'UTF-8',
            'page-size' => 'A4',
            'background' => false,
            'margin-top' => 0,
            'margin-bottom' => 0,
            'margin-left' => 0,
            'margin-right' => 0,
        ];

        $html = $this->render('header/pdf_content.html.twig', [
            'header' => $header,
            'details' => $details,
            'groups' => $groups,
            'groupsGlobal' => $groupsGlobal,
            'pathImg' => $pathImg,
            'manager_name' => $manager_name,
            'manager_function' => $manager_function,
            'sales_rep_name' => $sales_rep_name,
            'sales_rep_department' => $sales_rep_department,
            'in_charge_people' => $people,
            'revisions' => $revisions,
            'form' => $form,
        ])->getContent();

        $fileName = $header->getTitle() . '.pdf';

        return new PdfResponse(
            $snappy->getOutputFromHtml($html, $options),
            $fileName,
            array(
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $fileName . '.pdf"'
            )

        );
    }
}