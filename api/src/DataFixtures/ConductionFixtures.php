<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use App\Entity\User;
use App\Entity\Group;
use App\Entity\Scope;

class ConductionFixtures extends Fixture
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
        if ($this->params->get('app_domain') != "conduction.nl" && strpos($this->params->get('app_domain'), "conduction.nl") == false) {
            return false;
        }

    	$user= New User();
    	$user->setOrganization('https://wrc.conduction.nl/organizations/68b64145-0740-46df-a65a-9d3259c2fec8'); // Larping
    	$user->setUsername('info@conduction.nl');
    	$user->setPassword($this->encoder->encodePassword($user, 'lampenkap'));
    	$manager->persist($user);

    	// Larping
    	$groupUsers = new Group();
    	$groupUsers->setName('Users');
    	$groupUsers->setDescription('The general User group');
    	$groupUsers->setOrganization('https://wrc.conduction.nl/organizations/organizations/39405560-7859-4d16-943b-042d6c053a0f'); // Larping
    	$groupUsers->addUser($user);
    	$manager->persist($groupUsers);

        $groupBeheer = new Group();
        $groupBeheer->setName('Beheerder');
        $groupBeheer->setDescription('De beheerders die de congiruatie inregelen');
        $groupBeheer->setParent($groupUsers);
        $groupBeheer->setOrganization('https://wrc.conduction.nl/organizations/organizations/39405560-7859-4d16-943b-042d6c053a0f'); // Utrecht
        $groupBeheer->addUser($user);
        $manager->persist($groupBeheer);

        $manager->flush();
    }
}
