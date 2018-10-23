<?php

namespace App\Controller;

use App\Entity\ActivityGroup;
use App\Form\ActivityGroupType;
use App\Entity\Activity;
use App\Repository\ActivityGroupRepository;
use App\Repository\ActivityRepository;
use App\Service\GroupService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * @Route("/activity/group")
 */
class ActivityGroupController extends Controller
{
    /**
     * @Route("/", name="activity_group_index", methods="GET")
     */
    public function index(ActivityGroupRepository $activityGroupRepository): Response
    {
        return $this->render('activity_group/index.html.twig', ['activity_groups' => $activityGroupRepository->findAll()]);
    }

    /**
     * @Route("/new", name="activity_group_new", methods="GET|POST")
     */
    public function new(Request $request, GroupService $groupService, ActivityGroupRepository $activityGroupRepository): Response
    {
        $activityGroup = new ActivityGroup();
        $form = $this->createForm(ActivityGroupType::class, $activityGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($activityGroup);
            $em->flush();

            $this->reaffectSerialNumberActivityGroup();
            $this->reaffectSerialNumberActivity($activityGroup);

            return $this->redirectToRoute('activity_group_index');
        }

        $nonDisplay = $activityGroupRepository->findOneBy(array('referent' => true))? true: false;

        return $this->render('activity_group/new.html.twig', [
            'activity_group' => $activityGroup,
            'activities' => $activityGroup->getActivities(),
            'nonDisplay' => $nonDisplay,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="activity_group_show", methods="GET")
     */
    public function show(ActivityGroup $activityGroup): Response
    {
        return $this->render('activity_group/show.html.twig', ['activity_group' => $activityGroup]);
    }

    /**
     * @Route("/{id}/edit", name="activity_group_edit", methods="GET|POST")
     */
    public function edit(Request $request, ActivityGroup $activityGroup, ActivityRepository $activityRepository, ActivityGroupRepository $activityGroupRepository, GroupService $groupService): Response
    {
        $em = $this->getDoctrine()->getManager();
        $header = $em->getRepository(ActivityGroup::class)->find($activityGroup->getId());

        if (!$activityGroup) {
            throw $this->createNotFoundException('Pas de groupe trouvé pour l\'identifiant ' . $activityGroup->getId());
        }

        $originalActivities = new ArrayCollection();

        // Create an ArrayCollection of the current Tag objects in the database
        foreach ($activityGroup->getActivities() as $activity) {
            $originalActivities->add($activity);
        }

        $form = $this->createForm(ActivityGroupType::class, $activityGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // remove the relationship between the detail and the Header
            foreach ($originalActivities as $activity) {
                if (false === $activityGroup->getActivities()->contains($activity)) {
                    $activity->setActivityGroup(null);
                    $em->remove($activity);
                }
            }

            $this->getDoctrine()
                ->getManager()
                ->flush();

            $this->reaffectSerialNumberActivityGroup();
            $this->reaffectSerialNumberActivity($activityGroup);

            return $this->redirectToRoute('activity_group_edit', ['id' => $activityGroup->getId()]);
        }

        $nonDisplay = (!$activityGroup->getReferent() and $activityGroupRepository->findOneBy(array('referent' => true))? true: false);

        $undeletableActivityGroup = false;
        if ($activityGroup->getActivities()->count()>0) {
            $undeletableActivityGroup = true;
        }


        return $this->render('activity_group/edit.html.twig', [
            'activity_group' => $activityGroup,
            'activities' => $activityRepository->findAndSortBySerialNumber($activityGroup),
            'nonDisplay' => $nonDisplay,
            'undeletableActivityGroup' => $undeletableActivityGroup,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="activity_group_delete", methods="DELETE")
     */
    public function delete(Request $request, ActivityGroup $activityGroup): Response
    {
        if ($this->isCsrfTokenValid('delete' . $activityGroup->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($activityGroup);
            $em->flush();
        }

        $this->reaffectSerialNumberActivityGroup();

        return $this->redirectToRoute('activity_group_index');
    }

    // Pour réaffecter un numéro d'ordre selon un pas de 10
    public function reaffectSerialNumberActivityGroup()
    {
        $em = $this->getDoctrine()->getManager();
        $ActivityGroupRepository = $em->getRepository(ActivityGroup::class);
        $activityGroups = $ActivityGroupRepository->findAllOrderBySerialNumber();
        $serialNumber = 0;
        foreach ($activityGroups as $group) {
            $serialNumber = $serialNumber + 10;
            $group->setSerialNumber($serialNumber);
            $em = $this->getDoctrine()->getManager();
            $em->persist($group);
            $em->flush();
        }
    }

    // Pour réaffecter un numéro d'ordre selon un pas de 10
    public function reaffectSerialNumberActivity(ActivityGroup $activityGroup)
    {
        $em = $this->getDoctrine()->getManager();
        $ActivityRepository = $em->getRepository(Activity::class);
        $activities = $ActivityRepository->findAllOrderBySerialNumber($activityGroup);
        $serialNumber = 0;
        foreach ($activities as $act) {
            $serialNumber = $serialNumber + 10;
            $act->setSerialNumber($serialNumber);
            $em = $this->getDoctrine()->getManager();
            $em->persist($act);
            $em->flush();
        }
    }
}
