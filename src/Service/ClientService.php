<?php
/**
 * Created by PhpStorm.
 * User: dbollard
 * Date: 17/08/2018
 * Time: 16:09
 */

namespace App\Service;


use App\Entity\Client;
use App\Repository\ClientRepository;
use App\Repository\ParameterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;
use Symfony\Component\Finder\Finder;

class ClientService
{

    private $em;
    private $container;
    private $parameterRepository;

    public function __construct(EntityManager $em, ContainerInterface $container, ParameterRepository $parameterRepository)
    {
        $this->em = $em;
        $this->container = $container;
        $this->parameterRepository = $parameterRepository;

    }


    // Remove the relationship between the detail and the Header

    public function removeRelationship(ArrayCollection $originalInChargePersons, ArrayCollection $originalApplications, ObjectManager $entityManager)
    {

        $client = $this->client;

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
    }

    // Upload logo
    public function uploadLogo($client)
    {
        $file = $client->getLogo();

        $url = __DIR__ . '/public';
        $path = str_replace("\\", "/", $url);
        $pathLogo = str_replace("/src/Service", "", $path);

        $fileName = '';

        $finder = new Finder();

        $finder->files()->in($pathLogo . '/assets/images/logos');

        foreach($finder as $thing) {
            $files = substr($thing->getFilename(), 0, -4);

            if($client->getId() == $files) {
                $fileName = $thing->getFilename();
            }
        }

        if($file !== null) {
            $fileName = $client->getId() . '.' . $file->getClientOriginalExtension();
            $targetDir = $this->container->getParameter('logos');
            $file->move($targetDir, $fileName);
        }

        return $fileName;
    }
}