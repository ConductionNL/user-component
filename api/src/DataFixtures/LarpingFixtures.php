<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use App\Entity\User;
use App\Entity\Group;
use App\Entity\Scope;

class LarpingFixtures extends Fixture
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
    	// Lets make sure we only run these fixtures on huwelijksplanner enviroments
    	if(!in_array("larping.eu",$this->params->get('app_domains'))){
    		return false;
    	}
    	
    	
    	$user= New User();
    	$user->setOrganization('https://wrc.huwelijksplanner.online/organizations/68b64145-0740-46df-a65a-9d3259c2fec8'); // Larping
    	$user->setUsername('test@larping.eu');
    	$user->setPassword($this->encoder->encodePassword($user, 'bierflesje'));
    	$manager->persist($user);    	
    	
    	// Larping
    	$groupUsers = new Group();
    	$groupUsers->setName('Users');
    	$groupUsers->setDescription('The Users of Vortex Larping');
    	$groupUsers->setOrganization('https://wrc.larping.eu/organizations/organizations/39405560-7859-4d16-943b-042d6c053a0f'); // Larping
    	$groupUsers->addUser($user);
    	$manager->persist($groupUsers);
    	
    	$groupAdmin = new Group();
    	$groupAdmin->setName('Admin');
    	$groupAdmin->setDescription('The Administrators of Larping');
    	$groupAdmin->setParent($groupUsers);
    	$groupAdmin->setOrganization('https://wrc.larping.eu/organizations/organizations/39405560-7859-4d16-943b-042d6c053a0f'); // Larping
    	$groupAdmin->addUser($user);
    	$manager->persist($groupAdmin);    	
    	
    	// Vortex Adventures
    	
    	$groupUsers = new Group();
    	$groupUsers->setName('Users');
    	$groupUsers->setDescription('The Users of Vortex Adventures');
    	$groupUsers->setOrganization('https://wrc.larping.eu/organizations/0972a00f-1893-4e9b-ac13-0e43f225eca5'); //VA
    	$manager->persist($groupUsers);
    	
    	$groupAdmin= new Group();
    	$groupAdmin->setName('Admin');
    	$groupAdmin->setDescription('The Administrators of Vortex Adventures');
    	$groupAdmin->setParent($groupUsers);    	
    	$groupAdmin->setOrganization('https://wrc.larping.eu/organizations/0972a00f-1893-4e9b-ac13-0e43f225eca5'); //VA
    	$groupAdmin->addUser($user);    	
    	$manager->persist($groupAdmin);
    	
    	$groupMember = new Group();
    	$groupMember ->setName('Member');
    	$groupMember ->setDescription('The Members of Vortex Adventures');
    	$groupMember ->setParent($groupUsers);
    	$groupMember ->setOrganization('https://wrc.larping.eu/organizations/0972a00f-1893-4e9b-ac13-0e43f225eca5'); //VA 
    	$manager->persist($groupMember);
    	
    	$groupCrew= new Group();
    	$groupCrew->setName('Crew');
    	$groupCrew->setDescription('The Crew members of Vortex Adventures');
    	$groupCrew->setParent($groupUsers);
    	$groupCrew->setOrganization('https://wrc.larping.eu/organizations/0972a00f-1893-4e9b-ac13-0e43f225eca5'); //VA
    	$manager->persist($groupCrew);
    	
    	$groupGameMasters= new Group();
    	$groupGameMasters->setName('Game Masters');
    	$groupGameMasters->setDescription('The Game Masters of Vortex Adventures');
    	$groupGameMasters->setParent($groupCrew);
    	$groupGameMasters->setOrganization('https://wrc.larping.eu/organizations/0972a00f-1893-4e9b-ac13-0e43f225eca5'); //VA
    	$manager->persist($groupGameMasters);
    	
    	$groupVolunteers= new Group();
    	$groupVolunteers->setName('Volunteers');
    	$groupVolunteers->setDescription('The Volunteers of Vortex Adventures');
    	$groupVolunteers->setParent($groupCrew);
    	$groupVolunteers->setOrganization('https://wrc.larping.eu/organizations/0972a00f-1893-4e9b-ac13-0e43f225eca5'); //VA
    	$manager->persist($groupVolunteers);
    	
    	$groupExtras= new Group();
    	$groupExtras->setName('Extras');
    	$groupExtras->setDescription('The Extra\'s or npc\'s of Vortex Adventures');
    	$groupExtras->setParent($groupCrew);
    	$groupExtras->setOrganization('https://wrc.larping.eu/organizations/0972a00f-1893-4e9b-ac13-0e43f225eca5'); //VA
    	$manager->persist($groupExtras);
    	
    	$groupBoard= new Group();
    	$groupBoard->setName('Board');
    	$groupBoard->setDescription('The Board members of Vortex Adventures');
    	$groupBoard->setParent($groupCrew);
    	$groupBoard->setOrganization('https://wrc.larping.eu/organizations/0972a00f-1893-4e9b-ac13-0e43f225eca5'); //VA 
    	$manager->persist($groupBoard);
    	
    	$user= New User();
    	$user->setOrganization('https://wrc.larping.eu/organizations/0972a00f-1893-4e9b-ac13-0e43f225eca5'); // Larping
    	$user->setUsername('info@the-vortex.nl');
    	$user->setPassword($this->encoder->encodePassword($user, 'lampenkap1986'));
    	/*
    	$user->addGroup($groupUsers);
    	$user->addGroup($groupMember);
    	$user->addGroup($groupAdmin);
    	$user->addGroup($groupCrew);
    	$user->addGroup($groupGameMasters);
    	$user->addGroup($groupVolunteers);
    	$user->addGroup($groupExtras);
    	$user->addGroup($groupBoard);
    	*/
    	$manager->persist($user);    	
    	

        $manager->flush();
    }
}
