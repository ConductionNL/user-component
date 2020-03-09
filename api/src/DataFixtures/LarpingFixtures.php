<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use App\Entity\Group;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
    	// Lets make sure we only run these fixtures on huwelijksplanner enviroments
    	if(!in_array("larping.eu",$this->params->get('app_domains'))){
    		return false;
    	}
    	
    	// Vortex Adventures
    	$users = new Group();
    	$users->setName('Users');
    	$users->setDescription('The Users of Vortex Adventures');
    	$users->setOrganization('https://wrc.larping.eu/organizations/0972a00f-1893-4e9b-ac13-0e43f225eca5'); //VA
    	$users->persist($users);
    	
    	$group= new Group();
    	$group->setName('Admin');
    	$group->setDescription('The Adminsrators of Vortex Adventures');
    	$group->setParent($users);    	
    	$group->setOrganization('https://wrc.larping.eu/organizations/0972a00f-1893-4e9b-ac13-0e43f225eca5'); //VA
    	$group->persist($group);
    	
    	$crew= new Group();
    	$crew->setName('Member');
    	$crew->setDescription('The Members of Vortex Adventures');
    	$crew->setParent($users);
    	$crew->setOrganization('https://wrc.larping.eu/organizations/0972a00f-1893-4e9b-ac13-0e43f225eca5'); //VA
    	$crew->persist($crew);
    	
    	$crew= new Group();
    	$crew->setName('Crew');
    	$crew->setDescription('The Crew members of Vortex Adventures');
    	$crew->setParent($users);
    	$crew->setOrganization('https://wrc.larping.eu/organizations/0972a00f-1893-4e9b-ac13-0e43f225eca5'); //VA
    	$crew->persist($crew);
    	
    	$group= new Group();
    	$group->setName('Game Masters');
    	$group->setDescription('The Game Masters of Vortex Adventures');
    	$group->setParent($crew);
    	$group->setOrganization('https://wrc.larping.eu/organizations/0972a00f-1893-4e9b-ac13-0e43f225eca5'); //VA
    	$group->persist($group);
    	
    	$group= new Group();
    	$group->setName('Volunteers');
    	$group->setDescription('The Volunteers of Vortex Adventures');
    	$group->setParent($crew);
    	$group->setOrganization('https://wrc.larping.eu/organizations/0972a00f-1893-4e9b-ac13-0e43f225eca5'); //VA
    	$group->persist($group);
    	
    	$group= new Group();
    	$group->setName('Extras');
    	$group->setDescription('The Extra\'s or npc\'s of Vortex Adventures');
    	$group->setParent($crew);
    	$group->setOrganization('https://wrc.larping.eu/organizations/0972a00f-1893-4e9b-ac13-0e43f225eca5'); //VA
    	$group->persist($group);
    	
    	$group= new Group();
    	$group->setName('Board');
    	$group->setDescription('The Board members of Vortex Adventures');
    	$group->setParent($crew);
    	$group->setOrganization('https://wrc.larping.eu/organizations/0972a00f-1893-4e9b-ac13-0e43f225eca5'); //VA
    	$group->persist($group);

        $manager->flush();
    }
}
