<?php

namespace App\DataFixtures;

use App\Entity\Group;
use App\Entity\Provider;
use App\Entity\User;
use Conduction\CommonGroundBundle\Service\CommonGroundService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class StageFixtures extends Fixture
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
            $this->params->get('app_domain') != 'conduction.academy' && strpos($this->params->get('app_domain'), 'conduction.academy') == false
        ) {
            return false;
        }

        $userBedrijf = new User();
        $userBedrijf->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'ff0662b1-8393-467d-bddb-8a3d4ae521a5'])); // Conduction
        $userBedrijf->setUsername('bedrijf@test.nl');
        $userBedrijf->setPerson($this->commonGroundService->cleanUrl(['component'=>'cc', 'type'=>'people', 'id'=>'25006d28-350a-42e9-b9ed-7afb25d4321d']));
        if ($this->params->get('app_env') == 'prod') {
            $userBedrijf->setPassword($this->encoder->encodePassword($userBedrijf, bin2hex(openssl_random_pseudo_bytes(4))));
        } else {
            $userBedrijf->setPassword($this->encoder->encodePassword($userBedrijf, 'test1234'));
        }
        $manager->persist($userBedrijf);

        $groupUsers = new Group();
        $groupUsers->setName('Users');
        $groupUsers->setDescription('Alle gebruikers');
        $groupUsers->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'ff0662b1-8393-467d-bddb-8a3d4ae521a5'])); // Conduction
        $groupUsers->addUser($userBedrijf);

        $manager->persist($groupUsers);

        $id = Uuid::fromString('8a5e3ca2-c936-4810-86a5-87c4f3b3a4c9');
        $groupBedrijf = new Group();
        $groupBedrijf->setName('Test bedrijf stageplatform');
        $groupBedrijf->setDescription('De groep voor bedrijf testen');
        $groupBedrijf->setParent($groupUsers);
        $groupBedrijf->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'ff0662b1-8393-467d-bddb-8a3d4ae521a5'])); // Conduction
        $manager->persist($groupBedrijf);
        $groupBedrijf->setId($id);
        $manager->persist($groupBedrijf);
        $manager->flush();
        $groupBedrijf = $manager->getRepository('App:Group')->findOneBy(['id'=> $id]);
        $groupBedrijf->addUser($userBedrijf);

        $manager->persist($groupUsers);
        $manager->persist($groupBedrijf);

        $provider = new Provider();
        $provider->setName('id-vault stage platform');
        $provider->setDescription('id-vault provider');
        $provider->setType('id-vault');
        $provider->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $provider->setApplication($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'applications', 'id'=>'5265828b-85fb-4ad5-acd5-ade4da3fc593']));
        $provider->setConfiguration(['app_id'=>'62817d5c-0ba5-4aaa-81f2-ad0e5a763cdd', 'secret'=>'kjdIDAkj49283hasdnbdDASD84Os2Q']);
        $manager->persist($provider);

        $manager->flush();
    }
}
