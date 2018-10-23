<?php

namespace App\Service;

use App\Entity\ActivityGroup;
use Doctrine\ORM\EntityManager;
use App\Entity\Activity;

class GroupService
{

    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getDetailRate($detail)
    {

        $activityRepository = $this->em->getRepository(Activity::class);
        $activities = $activityRepository->findAll();

        $res = null;

        foreach ($activities as $activity) {

            if ($activity->getName() == $detail->getDescription()) {
                $activityRate = $activity->getRate()/100;

                $groupRate = $activity->getActivityGroup()->getRate()/100;

                $res = ($activityRate * $groupRate);

                return $res;
            }
        }

        return $res;
    }

    public function totalDaysEstimatedGroup($referent, $header) {

        $details = $header->getDetails();
        $nbJours = 0;
        foreach ($details as $detail) {
            if ($detail->getActivityGroup() === $referent) {
                $nbJours = $nbJours + $detail->getEstimatedDays();
            }
        }

        return $nbJours;
    }

    public function chexkInputActivities(ActivityGroup $activityGroup) {

        foreach ($activityGroup->getActivities() as $activity) {
            if ($activity->getMinHours() == null) {$activity->setMinHours(0);}
            if ($activity->getRate() == null) {$activity->setRate(0);}
        }

        return $activityGroup;
    }
}