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

        $id = '4085d475-063b-47ed-98eb-0a7d8b01f3b7';
        $group = new Group();
        $group->setName('admin');
        $group->setDescription('Kunnen beheren van een onderneming');
        $group->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $manager->persist($group);
        $group->setId($id);
        $manager->persist($group);
        $manager->flush();
        $group = $manager->getRepository('App:Group')->findOneBy(['id' => $id]);

        $scope = new Scope();
        $scope->setName('admin');
        $scope->setDescription('Kunnen beheren van een organizatie');
        $scope->setCode('wrc.organization.write');
        $scope->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $scope->addUserGroup($group);
        $manager->persist($scope);

        $scope = new Scope();
        $scope->setName('nodes');
        $scope->setDescription('Kunnen beheren van nodes');
        $scope->setCode('chin.node.write');
        $scope->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $scope->addUserGroup($group);
        $manager->persist($scope);

        $scope = new Scope();
        $scope->setName('places');
        $scope->setDescription('Kunnen beheren van een plaatsen');
        $scope->setCode('lc.place.write');
        $scope->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $scope->addUserGroup($group);
        $manager->persist($scope);

        $user = new User();
        $user->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'2106575d-50f3-4f2b-8f0f-a2d6bc188222']));
        $user->setUsername('jan@zwarteraaf.nl');
        $user->setPerson($this->commonGroundService->cleanUrl(['component'=>'cc', 'type'=>'people', 'id'=>'841949b7-7488-429f-9171-3a4338b541a6']));
        $user->setPassword($this->encoder->encodePassword($user, 'test1234'));
        $manager->persist($user);

        $group->addUser($user);
        $manager->persist($group);

        $user = new User();
        $user->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'a9398c45-7497-4dbd-8dd1-1be4f3384ed7']));
        $user->setUsername('bob@goudlust.nl');
        $user->setPerson($this->commonGroundService->cleanUrl(['component'=>'cc', 'type'=>'people', 'id'=>'2bdb2fe0-784d-46a3-949e-7db99d2fc089']));
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

        //Providers
        $provider = new Provider();
        $provider->setName('idin');
        $provider->setDescription('idin provider');
        $provider->setType('idin');
        $provider->setApplication($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'applications', 'id'=>'31a2ad29-ee03-4aa9-be81-abf1fda7bbcc']));
        $provider->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $manager->persist($provider);

        $provider = new Provider();
        $provider->setName('facebook');
        $provider->setDescription('facebook');
        $provider->setType('facebook');
        $provider->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $provider->setApplication($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'applications', 'id'=>'31a2ad29-ee03-4aa9-be81-abf1fda7bbcc']));
        $provider->setConfiguration(['app_id'=>str_replace('\'', '', $this->params->get('facebook_id')), 'secret'=>$this->params->get('facebook_secret')]);
        $manager->persist($provider);

        $provider = new Provider();
        $provider->setName('gmail');
        $provider->setDescription('gmail');
        $provider->setType('gmail');
        $provider->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $provider->setApplication($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'applications', 'id'=>'31a2ad29-ee03-4aa9-be81-abf1fda7bbcc']));
        $provider->setConfiguration(['app_id'=>$this->params->get('gmail_id'), 'secret'=>$this->params->get('gmail_secret')]);
        $manager->persist($provider);

        $provider = new Provider();
        $provider->setName('reset');
        $provider->setDescription('provider for resetting password');
        $provider->setType('reset');
        $provider->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $provider->setApplication($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'applications', 'id'=>'31a2ad29-ee03-4aa9-be81-abf1fda7bbcc']));
        $manager->persist($provider);

        $manager->flush();
    }
}
