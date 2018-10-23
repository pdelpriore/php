<?php
/**
 * Created by PhpStorm.
 * User: dbollard
 * Date: 09/08/2018
 * Time: 19:31
 */

namespace App\Service;


use App\Repository\ParameterRepository;
use Doctrine\ORM\EntityManager;

class WebDevisService
{
    private $em;
    private $parameterRepository;

    public function __construct(EntityManager $em,ParameterRepository $parameterRepository)
    {
        $this->em = $em;
        $this->parameterRepository = $parameterRepository;
    }


    public function getParameter($paramKey)
    {

        if ($this->parameterRepository->findOneBy(array('paramKey' => $paramKey)) != null) {
            $paramValue = $this->parameterRepository->findOneBy(array('paramKey' => $paramKey))->getParamValue();
        } else {
            $paramValue = null;
        }

        return $paramValue;
    }
}
