<?php

namespace App\DataFixtures;

use App\Entity\Group;
use App\Entity\Provider;
use Conduction\CommonGroundBundle\Service\CommonGroundService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class IdVaultFixtures extends Fixture
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
            ($this->params->get('app_domain') != 'id-vault.com' && strpos($this->params->get('app_domain'), 'id-vault.com') == false)
        ) {
            return false;
        }

        $id = 'c3c463b9-8d39-4cc0-b62c-826d8f5b7d8c';
        $group = new Group();
        $group->setName('developer');
        $group->setDescription('developer opties mogen zien en gebruiken');
        $group->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'360e17fb-1a98-48b7-a2a8-212c79a5f51a']));
        $manager->persist($group);
        $group->setId($id);
        $manager->persist($group);
        $manager->flush();
        $manager->getRepository('App:Group')->findOneBy(['id' => $id]);

        $id = 'ff0a0468-3b92-4222-9bca-201df1ab0f42';
        $scope = new Group();
        $scope->setName('developer.view');
        $scope->setDescription('developer opties willen kunnen zien en gebruiken');
        $group->setCode('developer.view');
        $scope->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'360e17fb-1a98-48b7-a2a8-212c79a5f51a']));
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $manager->getRepository('App:Group')->findOneBy(['id' => $id]);

        //Providers
        $provider = new Provider();
        $provider->setName('facebook');
        $provider->setDescription('facebook');
        $provider->setType('facebook');
        $provider->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $provider->setApplication($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'applications', 'id'=>'22888b97-d12b-4505-9a20-ee9cc148d442']));
        $provider->setConfiguration(['app_id'=>str_replace('\'', '', $this->params->get('facebook_id')), 'secret'=>$this->params->get('facebook_secret')]);
        $manager->persist($provider);

        $provider = new Provider();
        $provider->setName('gmail');
        $provider->setDescription('gmail');
        $provider->setType('gmail');
        $provider->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $provider->setApplication($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'applications', 'id'=>'22888b97-d12b-4505-9a20-ee9cc148d442']));
        $provider->setConfiguration(['app_id'=>$this->params->get('gmail_id'), 'secret'=>$this->params->get('gmail_secret')]);
        $manager->persist($provider);

        $provider = new Provider();
        $provider->setName('token');
        $provider->setDescription('provider for one time tokens');
        $provider->setType('token');
        $provider->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $provider->setApplication($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'applications', 'id'=>'22888b97-d12b-4505-9a20-ee9cc148d442']));
        $manager->persist($provider);

        $provider = new Provider();
        $provider->setName('github');
        $provider->setDescription('github provider');
        $provider->setType('github');
        $provider->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $provider->setApplication($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'applications', 'id'=>'22888b97-d12b-4505-9a20-ee9cc148d442']));
        $manager->persist($provider);

        $provider = new Provider();
        $provider->setName('oauth');
        $provider->setDescription('oauth provider');
        $provider->setType('oauth');
        $provider->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $provider->setApplication($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'applications', 'id'=>'22888b97-d12b-4505-9a20-ee9cc148d442']));
        $manager->persist($provider);

        $manager->flush();
    }
}
