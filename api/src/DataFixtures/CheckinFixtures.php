<?php

namespace App\DataFixtures;

use App\Entity\Group;
use App\Entity\Provider;
use App\Entity\Scope;
use App\Entity\User;
use Conduction\CommonGroundBundle\Service\CommonGroundService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CheckinFixtures extends Fixture
{
    private $params;
    private $commonGroundService;
    private $encoder;

    public function __construct(ParameterBagInterface $params, CommonGroundService $commonGroundService, UserPasswordEncoderInterface $encoder)
    {
        $this->params = $params;
        $this->commonGroundService = $commonGroundService;
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        // Lets make sure we only run these fixtures on huwelijksplanner enviroments
        if (
            ($this->params->get('app_domain') != 'zuiddrecht.nl' && strpos($this->params->get('app_domain'), 'zuiddrecht.nl') == false) &&
            ($this->params->get('app_domain') != 'zuid-drecht.nl' && strpos($this->params->get('app_domain'), 'zuid-drecht.nl') == false)
        ) {
            return false;
        }

        $group = new Group();
        $group->setName('Ondernemers');
        $group->setDescription('De ondernemers op het platform');
        $group->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $manager->persist($group);

        $scope = new Scope();
        $scope->setName('admin');
        $scope->setDescription('Kunnen beheren van een onderneming');
        $scope->setCode('checkin.admin');
        $scope->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $scope->addUserGroup($group);
        $manager->persist($scope);

        $user = new User();
        $user->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'2106575d-50f3-4f2b-8f0f-a2d6bc188222']));
        $user->setUsername('jan@zwarteraaf.nl');
        $user->setPerson($this->commonGroundService->cleanUrl(['component'=>'cc', 'type'=>'people', 'id'=>'25006d28-350a-42e9-b9ed-7afb25d4321d']));
        $user->setPassword($this->encoder->encodePassword($user, 'test1234'));
        $manager->persist($user);

        $group->addUser($user);
        $manager->persist($group);

        $user = new User();
        $user->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'a9398c45-7497-4dbd-8dd1-1be4f3384ed7']));
        $user->setUsername('bob@goudlust.nl');
        $user->setPerson($this->commonGroundService->cleanUrl(['component'=>'cc', 'type'=>'people', 'id'=>'25006d28-350a-42e9-b9ed-7afb25d4321d']));
        $user->setPassword($this->encoder->encodePassword($user, 'test1234'));
        $manager->persist($user);

        $group->addUser($user);
        $manager->persist($group);

        $user = new User();
        $user->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'8812dc58-6bbe-4028-8e36-96f402bf63dd']));
        $user->setUsername('mark@dijkzicht.nl');
        $user->setPerson($this->commonGroundService->cleanUrl(['component'=>'cc', 'type'=>'people', 'id'=>'25006d28-350a-42e9-b9ed-7afb25d4321d']));
        $user->setPassword($this->encoder->encodePassword($user, 'test1234'));
        $manager->persist($user);

        $group->addUser($user);
        $manager->persist($group);


        $manager->flush();
    }
}
