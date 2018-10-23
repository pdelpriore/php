<?php
/**
 * Created by PhpStorm.
 * User: dbollard
 * Date: 10/08/2018
 * Time: 08:44
 */

namespace App\Service;


use App\Repository\ActivityRepository;
use App\Repository\ParameterRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

class DetailService

{
    private $em;
    private $activityRepository;
    private $parameterRepository;

    public function __construct(EntityManager $em, ActivityRepository $activityRepository, ParameterRepository $parameterRepository)
    {
        $this->em = $em;
        $this->activityRepository = $activityRepository;
        $this->parameterRepository = $parameterRepository;
    }

    public function lowDays($detail)
    {

        if ($detail->getEstimatedDays() == null || $detail->getCertaintyLevel() == null) {
            $res = 0;
        } else {
            $estimatedDays = $detail->getEstimatedDays();
            $ponderateur = $detail->getCertaintyLevel()->getRate();

            $res = $estimatedDays / $ponderateur;
        }

        return $res;

    }

    public function highDays($detail)
    {

        if ($detail->getEstimatedDays() == null || $detail->getCertaintyLevel() == null) {
            $res = 0;
        } else {
            $estimatedDays = $detail->getEstimatedDays();
            $ponderateur = $detail->getCertaintyLevel()->getRate();

            $res = $estimatedDays * $ponderateur;
        }

        return $res;
    }

    public function calculatedDays($detail)
    {

        if ($detail->getEstimatedDays() == null) {

            $res = 0;

        } else {

            $estimatedDays = $detail->getEstimatedDays();
            $lowDays = $detail->getLowDays();
            $highDays = $detail->getHighDays();
            $calculated = ($lowDays + $highDays + 4 * $estimatedDays) / 6;

            $res = $this->roundingDays($calculated);

        }

        return $res;

    }

    public function roundingDays($days)
    {

        $roundStep = $this->getHoursInADay()/$this->getTimeLapse();

        $res = round($days * $roundStep, 0) / $roundStep;
        return $res;
    }

    public function getDailyCost($detail)
    {
        if ($detail->getProfil() != null) {
            if ($detail->getheader()->getApplication()->getClient()->getDaylyCost() != 0
                && $detail->getProfil()->getDefaultSelected()) {
                $res = $detail->getheader()->getApplication()->getClient()->getDaylyCost();
            } else {
                $res = $detail->getProfil()->getDaylyCost();
            }
        } else {
            $res = 0;
        }

        return $res;
    }

    public function calculatePrice($detail)
    {
//        if ($detail->getEstimatedDays() != null) {
//            if ($detail->getheader()->getApplication()->getClient()->getDaylyCost() != 0
//            && $detail->getProfil()->getDefaultSelected()) {
//                $tauxJ = $detail->getheader()->getApplication()->getClient()->getDaylyCost();
//            } else {
//                $tauxJ = $detail->getProfil()->getDaylyCost();
//            }
//
//            $calculatedDays = $detail->getCalculatedDays();
//            $res = $calculatedDays * $tauxJ;
//
//        } else {
//            $res = 0;
//        }
//
//        return $res;

        if ($detail->getCalculatedDays() != null
            && $detail->getDailyCost() != null) {
            $res = $detail->getCalculatedDays()*$detail->getDailyCost();
        }
        else {
            $res = 0;
        }

        return $res;
    }

    public function floor($detail)
    {
        $floor = 0;


        $activities = $detail->getActivityGroup()->getActivities();

        foreach ($activities as $activity) {

            if ($activity->getName() == $detail->getDescription()) {
                $floor = $activity->getMinHours() / $this->getHoursInADay();

            }
        }

        $detail->setEstimatedDays(($floor > $detail->getEstimatedDays()) ? $floor : $detail->getEstimatedDays());
        $detail->setCalculatedDays(($floor > $detail->getCalculatedDays()) ? $floor : $detail->getCalculatedDays());

        return $detail;
    }

    function getHoursInADay() {
//        Si le paramètre "HOURS_IN_A_DAY n'est pas (ou est mal) défini alors "Nb d'hures dans une journée" = 8h
        if ($this->parameterRepository->findOneBy(array('paramKey' => 'HOURS_IN_A_DAY')) != null
            and is_int((int)$this->parameterRepository->findOneBy(array('paramKey' => 'HOURS_IN_A_DAY'))->getParamValue())
            and (int)$this->parameterRepository->findOneBy(array('paramKey' => 'HOURS_IN_A_DAY'))->getParamValue() > 0
            and (int)$this->parameterRepository->findOneBy(array('paramKey' => 'HOURS_IN_A_DAY'))->getParamValue() > 24) {

            $hoursInADay = (int)$this->parameterRepository->findOneBy(array('paramKey' => 'HOURS_IN_A_DAY'))->getParamValue();

        } else {

            $hoursInADay = 8;

        }

        return $hoursInADay;
    }

    function getTimeLapse () {
//        Si le paramètre "TIME_LAPSE n'est pas (ou est mal) défini alors "pas horaire" = 2h
        if ($this->parameterRepository->findOneBy(array('paramKey' => 'TIME_LAPSE')) != null
            and is_int((int)$this->parameterRepository->findOneBy(array('paramKey' => 'TIME_LAPSE'))->getParamValue())
            and (int)$this->parameterRepository->findOneBy(array('paramKey' => 'TIME_LAPSE'))->getParamValue() > 0
            and (int)$this->parameterRepository->findOneBy(array('paramKey' => 'TIME_LAPSE'))->getParamValue() <= $this->getHoursInADay()) {

            $timeLapse = (int)$this->parameterRepository->findOneBy(array('paramKey' => 'TIME_LAPSE'))->getParamValue();

        } else {

            $timeLapse = 2;

        }

        return $timeLapse;
    }
}