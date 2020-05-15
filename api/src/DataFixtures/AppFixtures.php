<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use App\Entity\User;
use App\Entity\Group;
use App\Entity\Scope;

class AppFixtures extends Fixture
{
    private $params;
    private $encoder;

    public function __construct(ParameterBagInterface $params, UserPasswordEncoderInterface $encoder)
    {
        $this->params = $params;
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        // Lets make sure we only run these fixtures on larping enviroment
        if (strpos($this->params->get('app_domain'), "conduction.nl") == false) {
           // return false;
        }

        $componentList = [
            "vrc" => ["requests", "submitters"],
            "vtc" => ["requestTypes", "properties"],
        ];

        $scopes = ['create','read','update','delete'];

        foreach($componentList as $code=> $resources){
            // N tot 2 @todo better formuleren
            foreach($resources as $resource){
                // N tot 3 noooooooo
                foreach($scopes as $scope){

                    $scope = new Scope();
                    $scope->setName($scope.' '.$resources);
                    $scope->setCode($code.'.'.$resource.'.'.$scope);
                    $manager->persist($scope);
                }

            }

        }


        $manager->flush();
    }
}
