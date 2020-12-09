<?php

namespace App\DataFixtures;

use App\Entity\Group;
use App\Entity\Provider;
use App\Entity\User;
use Conduction\CommonGroundBundle\Service\CommonGroundService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class LarpingFixtures extends Fixture
{
    private $params;
    private $encoder;
    private $commonGroundService;

    public function __construct(ParameterBagInterface $params, UserPasswordEncoderInterface $encoder, CommonGroundService $commonGroundService)
    {
        $this->params = $params;
        $this->encoder = $encoder;
        $this->commonGroundService = $commonGroundService;
    }

    public function load(ObjectManager $manager)
    {
        // Lets make sure we only run these fixtures on larping enviroment
        if (
            !$this->params->get('app_build_all_fixtures') &&
            $this->params->get('app_domain') != 'zuid-drecht.nl' && strpos($this->params->get('app_domain'), 'zuid-drecht.nl') == false &&
            $this->params->get('app_domain') != 'larping.eu' && strpos($this->params->get('app_domain'), 'larping.eu') == false
        ) {
            return false;
        }

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
        $provider->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'7b863976-0fc3-4f49-a4f7-0bf7d2f2f535']));
        $provider->setApplication($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'applications', 'id'=>'9798cae6-187a-434f-bd66-f1dc2cc61466']));
        $provider->setConfiguration(['app_id'=>$this->params->get('gmail_id'), 'secret'=>$this->params->get('gmail_secret')]);
        $manager->persist($provider);

        // Larping provider
        $provider = new Provider();
        $provider->setName('id-vault');
        $provider->setDescription('id-vault provider');
        $provider->setType('id-vault');
        $provider->setOrganization($this->commonGroundService->cleanUrl(['component' => 'wrc', 'type' => 'organizations', 'id' => '7b863976-0fc3-4f49-a4f7-0bf7d2f2f535']));
        $provider->setApplication($this->commonGroundService->cleanUrl(['component' => 'wrc', 'type' => 'applications', 'id' => '9798cae6-187a-434f-bd66-f1dc2cc61466']));
        $provider->setConfiguration(['app_id'=>'c243189f-11cf-40c5-8859-6a57555328bf', 'secret'=>'eeb22abf509d45c59ddf97c8c39b67ae']);
        $manager->persist($provider);

        $manager->flush();

        $user = new User();
        $user->setOrganization($this->commonGroundService->cleanUrl(['component' => 'wrc', 'type' => 'organizations', 'id' => '7b863976-0fc3-4f49-a4f7-0bf7d2f2f535'])); // Larping
        $user->setUsername('test@larping.eu');
        $user->setPassword($this->encoder->encodePassword($user, 'bierflesje'));
        $manager->persist($user);
//
//        // Larping
//        $groupUsers = new Group();
//        $groupUsers->setName('Users');
//        $groupUsers->setDescription('The Users of Vortex Larping');
//        $groupUsers->setOrganization('https://wrc.larping.eu/organizations/organizations/39405560-7859-4d16-943b-042d6c053a0f'); // Larping
//        $groupUsers->addUser($user);
//        $manager->persist($groupUsers);
//
//        $groupAdmin = new Group();
//        $groupAdmin->setName('Admin');
//        $groupAdmin->setDescription('The Administrators of Larping');
//        $groupAdmin->setParent($groupUsers);
//        $groupAdmin->setOrganization('https://wrc.larping.eu/organizations/organizations/39405560-7859-4d16-943b-042d6c053a0f'); // Larping
//        $groupAdmin->addUser($user);
//        $manager->persist($groupAdmin);
//
//        // Vortex Adventures
//
//        $groupUsers = new Group();
//        $groupUsers->setName('Users');
//        $groupUsers->setDescription('The Users of Vortex Adventures');
//        $groupUsers->setOrganization('https://wrc.larping.eu/organizations/0972a00f-1893-4e9b-ac13-0e43f225eca5'); //VA
//        $manager->persist($groupUsers);
//
//        $groupAdmin = new Group();
//        $groupAdmin->setName('Admin');
//        $groupAdmin->setDescription('The Administrators of Vortex Adventures');
//        $groupAdmin->setParent($groupUsers);
//        $groupAdmin->setOrganization('https://wrc.larping.eu/organizations/0972a00f-1893-4e9b-ac13-0e43f225eca5'); //VA
//        $groupAdmin->addUser($user);
//        $manager->persist($groupAdmin);
//
//        $groupMember = new Group();
//        $groupMember->setName('Member');
//        $groupMember->setDescription('The Members of Vortex Adventures');
//        $groupMember->setParent($groupUsers);
//        $groupMember->setOrganization('https://wrc.larping.eu/organizations/0972a00f-1893-4e9b-ac13-0e43f225eca5'); //VA
//        $manager->persist($groupMember);
//
//        $groupCrew = new Group();
//        $groupCrew->setName('Crew');
//        $groupCrew->setDescription('The Crew members of Vortex Adventures');
//        $groupCrew->setParent($groupUsers);
//        $groupCrew->setOrganization('https://wrc.larping.eu/organizations/0972a00f-1893-4e9b-ac13-0e43f225eca5'); //VA
//        $manager->persist($groupCrew);
//
//        $groupGameMasters = new Group();
//        $groupGameMasters->setName('Game Masters');
//        $groupGameMasters->setDescription('The Game Masters of Vortex Adventures');
//        $groupGameMasters->setParent($groupCrew);
//        $groupGameMasters->setOrganization('https://wrc.larping.eu/organizations/0972a00f-1893-4e9b-ac13-0e43f225eca5'); //VA
//        $manager->persist($groupGameMasters);
//
//        $groupVolunteers = new Group();
//        $groupVolunteers->setName('Volunteers');
//        $groupVolunteers->setDescription('The Volunteers of Vortex Adventures');
//        $groupVolunteers->setParent($groupCrew);
//        $groupVolunteers->setOrganization('https://wrc.larping.eu/organizations/0972a00f-1893-4e9b-ac13-0e43f225eca5'); //VA
//        $manager->persist($groupVolunteers);
//
//        $groupExtras = new Group();
//        $groupExtras->setName('Extras');
//        $groupExtras->setDescription('The Extra\'s or npc\'s of Vortex Adventures');
//        $groupExtras->setParent($groupCrew);
//        $groupExtras->setOrganization('https://wrc.larping.eu/organizations/0972a00f-1893-4e9b-ac13-0e43f225eca5'); //VA
//        $manager->persist($groupExtras);
//
//        $groupBoard = new Group();
//        $groupBoard->setName('Board');
//        $groupBoard->setDescription('The Board members of Vortex Adventures');
//        $groupBoard->setParent($groupCrew);
//        $groupBoard->setOrganization('https://wrc.larping.eu/organizations/0972a00f-1893-4e9b-ac13-0e43f225eca5'); //VA
//        $manager->persist($groupBoard);
//
//        $user = new User();
//        $user->setOrganization('https://wrc.larping.eu/organizations/0972a00f-1893-4e9b-ac13-0e43f225eca5'); // Larping
//        $user->setUsername('info@the-vortex.nl');
//        $user->setPassword($this->encoder->encodePassword($user, 'lampenkap1986'));
//        /*
//    	$user->addGroup($groupUsers);
//    	$user->addGroup($groupMember);
//    	$user->addGroup($groupAdmin);
//    	$user->addGroup($groupCrew);
//    	$user->addGroup($groupGameMasters);
//    	$user->addGroup($groupVolunteers);
//    	$user->addGroup($groupExtras);
//    	$user->addGroup($groupBoard);
//    	*/
//        $manager->persist($user);
//
//        $manager->flush();
    }
}
