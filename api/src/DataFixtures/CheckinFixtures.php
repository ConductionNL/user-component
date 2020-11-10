<?php

namespace App\DataFixtures;

use App\Entity\Group;
use App\Entity\Provider;
use App\Entity\Scope;
use App\Entity\User;
use Conduction\CommonGroundBundle\Service\CommonGroundService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
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
            ($this->params->get('app_domain') != 'zuid-drecht.nl' && strpos($this->params->get('app_domain'), 'zuid-drecht.nl') == false) &&
            ($this->params->get('app_domain') != 'checking.nu' && strpos($this->params->get('app_domain'), 'checking.nu') == false)
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
        $user->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'8b3f28c4-4163-47f1-9242-a4050bc26ede']));
        $user->setUsername('jan@zwarteraaf.nl');
        $user->setPerson($this->commonGroundService->cleanUrl(['component'=>'cc', 'type'=>'people', 'id'=>'841949b7-7488-429f-9171-3a4338b541a6']));

        if ($this->params->get('app_env') == 'prod') {
            $user->setPassword($this->encoder->encodePassword($user, bin2hex(openssl_random_pseudo_bytes(4))));
        } else {
            $user->setPassword($this->encoder->encodePassword($user, 'test1234'));
        }

        $manager->persist($user);
        $group->addUser($user);
        $manager->persist($group);

        $user = new User();
        $user->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'62bff497-cb91-443e-9da9-21a0b38cd536']));
        $user->setUsername('creative@grounds.nl');
        $user->setPerson($this->commonGroundService->cleanUrl(['component'=>'cc', 'type'=>'people', 'id'=>'2bdb2fe0-784d-46a3-949e-7db99d2fc089']));

        if ($this->params->get('app_env') == 'prod') {
            $user->setPassword($this->encoder->encodePassword($user, bin2hex(openssl_random_pseudo_bytes(4))));
        } else {
            $user->setPassword($this->encoder->encodePassword($user, 'test1234'));
        }

        $manager->persist($user);
        $group->addUser($user);
        $manager->persist($group);

        $user = new User();
        $user->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'a3c5906a-5cd2-4a51-82a6-5833bfa094e1']));
        $user->setUsername('bob@goudlust.nl');
        $user->setPerson($this->commonGroundService->cleanUrl(['component'=>'cc', 'type'=>'people', 'id'=>'2bdb2fe0-784d-46a3-949e-7db99d2fc089']));

        if ($this->params->get('app_env') == 'prod') {
            $user->setPassword($this->encoder->encodePassword($user, bin2hex(openssl_random_pseudo_bytes(4))));
        } else {
            $user->setPassword($this->encoder->encodePassword($user, 'test1234'));
        }

        $manager->persist($user);
        $group->addUser($user);
        $manager->persist($group);

        $user = new User();
        $user->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'f302b75e-a233-4ddf-95b5-f8603f2e80e9']));
        $user->setUsername('mark@dijkzicht.nl');
        $user->setPerson($this->commonGroundService->cleanUrl(['component'=>'cc', 'type'=>'people', 'id'=>'25006d28-350a-42e9-b9ed-7afb25d4321d']));

        if ($this->params->get('app_env') == 'prod') {
            $user->setPassword($this->encoder->encodePassword($user, bin2hex(openssl_random_pseudo_bytes(4))));
        } else {
            $user->setPassword($this->encoder->encodePassword($user, 'test1234'));
        }

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
        $provider->setName('token');
        $provider->setDescription('provider for one time tokens');
        $provider->setType('token');
        $provider->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $provider->setApplication($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'applications', 'id'=>'31a2ad29-ee03-4aa9-be81-abf1fda7bbcc']));
        $manager->persist($provider);

        $provider = new Provider();
        $provider->setName('irma');
        $provider->setDescription('Irma provider');
        $provider->setType('irma');
        $provider->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $provider->setApplication($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'applications', 'id'=>'31a2ad29-ee03-4aa9-be81-abf1fda7bbcc']));
        $manager->persist($provider);

        $provider = new Provider();
        $provider->setName('id-vault checkings');
        $provider->setDescription('id-vault provider');
        $provider->setType('id-vault');
        $provider->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $provider->setApplication($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'applications', 'id'=>'31a2ad29-ee03-4aa9-be81-abf1fda7bbcc']));
        $provider->setConfiguration(['app_id'=>'1fd19369-a947-42c4-95da-4fbe143237e1','secret'=>'kjdIDAkj98733hasdnbdDASD84Os2Q']);
        $manager->persist($provider);

        $manager->flush();
    }
}
