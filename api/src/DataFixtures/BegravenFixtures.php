<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use App\Entity\User;
use App\Entity\Group;
use App\Entity\Scope;

class BegravenFixtures extends Fixture
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
        if (strpos($this->params->get('app_domain'), "begraven.zaakonline.nl") == false) {
            return false;
        }

    	$userTest= New User();
    	$userTest->setOrganization('https://wrc.dev.begraven.zaakonline.nl/organizations/d736013f-ad6d-4885-b816-ce72ac3e1384'); // Hoorn
    	$userTest->setUsername('test@hoorn.nl');
    	$userTest->setPassword($this->encoder->encodePassword($userTest, 'test1234'));
    	$manager->persist($userTest);

    	$userBalie= New User();
    	$userBalie->setOrganization('https://wrc.dev.begraven.zaakonline.nl/organizations/d736013f-ad6d-4885-b816-ce72ac3e1384'); // Hoorn
    	$userBalie->setUsername('balie@hoorn.nl');
    	$userBalie->setPassword($this->encoder->encodePassword($userBalie, 'test1234')) ;
    	$manager->persist($userBalie);

    	$userLocatie = New User();
    	$userLocatie->setOrganization('https://wrc.dev.begraven.zaakonline.nl/organizations/d736013f-ad6d-4885-b816-ce72ac3e1384'); // Hoorn
    	$userLocatie->setUsername('locatie@hoorn.nl');
    	$userLocatie->setPassword('test1234' );
    	$manager->persist($userLocatie);

    	$usertTrouwambtenaar = New User();
    	$usertTrouwambtenaar->setOrganization('https://wrc.dev.begraven.zaakonline.nl/organizations/d736013f-ad6d-4885-b816-ce72ac3e1384'); // Hoorn
    	$usertTrouwambtenaar->setUsername('trouwambtenaar@hoorn.nl');
    	$usertTrouwambtenaar->setPassword($this->encoder->encodePassword($usertTrouwambtenaar, 'test1234'));
    	$manager->persist($usertTrouwambtenaar);

    	$userBeheer = New User();
    	$userBeheer->setOrganization('https://wrc.dev.begraven.zaakonline.nl/organizations/d736013f-ad6d-4885-b816-ce72ac3e1384'); // Hoorn
    	$userBeheer->setUsername('beheer@hoorn.nl');
    	$userBeheer->setPassword($this->encoder->encodePassword($userBeheer, 'test1234'));
    	$manager->persist($userBeheer);

    	// Vortex Adventures
    	$groupUsers= new Group();
    	$groupUsers->setName('Users');
    	$groupUsers->setDescription('Alle gebruikers');
    	$groupUsers->setOrganization('https://wrc.dev.begraven.zaakonline.nl/organizations/d736013f-ad6d-4885-b816-ce72ac3e1384'); // Hoorn
    	$groupUsers->addUser($userBalie);
    	$groupUsers->addUser($userLocatie);
    	$groupUsers->addUser($usertTrouwambtenaar);
    	$groupUsers->addUser($userBeheer);
    	$manager->persist($groupUsers);

    	$groupBalie = new Group();
    	$groupBalie->setName('Balie Medewerkers');
    	$groupBalie->setDescription('De balliemedewerkers');
    	$groupBalie->setParent($groupUsers);
    	$groupBalie->setOrganization('https://wrc.dev.begraven.zaakonline.nl/organizations/d736013f-ad6d-4885-b816-ce72ac3e1384'); // Hoorn
    	$groupBalie->addUser($userBalie);
    	$manager->persist($groupBalie);

    	$groupLocatie= new Group();
    	$groupLocatie->setName('Locatie beheerders');
    	$groupLocatie->setDescription('De hbeheerders van een of meerdere locaties');
    	$groupLocatie->setParent($groupUsers);
    	$groupLocatie->setOrganization('https://wrc.dev.begraven.zaakonline.nl/organizations/d736013f-ad6d-4885-b816-ce72ac3e1384'); // Hoorn
    	$groupLocatie->addUser($userLocatie);
    	$manager->persist($groupLocatie);

    	$groupTrouwambtenaar= new Group();
    	$groupTrouwambtenaar->setName('Trouw Ambtenaar');
    	$groupTrouwambtenaar->setDescription('De ambtenaren die het huwelijk voltrekken');
    	$groupTrouwambtenaar->setParent($groupUsers);
    	$groupTrouwambtenaar->setOrganization('https://wrc.dev.begraven.zaakonline.nl/organizations/d736013f-ad6d-4885-b816-ce72ac3e1384'); // Hoorn
    	$groupTrouwambtenaar->addUser($usertTrouwambtenaar);
    	$manager->persist($groupTrouwambtenaar);

    	$groupBeheer = new Group();
    	$groupBeheer->setName('Beheerder');
    	$groupBeheer->setDescription('De beheerders die de congiruatie inregelen');
    	$groupBeheer->setParent($groupUsers);
    	$groupBeheer->setOrganization('https://wrc.dev.begraven.zaakonline.nl/organizations/d736013f-ad6d-4885-b816-ce72ac3e1384'); // Hoorn
    	$groupBeheer->addUser($userBeheer);
    	$manager->persist($groupBeheer);

    	$scope = new Scope();
    	$scope->setName('Verzoek schrijven');
    	$scope->setDescription('Kunnen schrijven op een verzoek');
    	$scope->setCode('vrc.request.write');
    	$scope->setOrganization('https://wrc.dev.begraven.zaakonline.nl/organizations/d736013f-ad6d-4885-b816-ce72ac3e1384'); // Hoorn
    	$scope->setApplication('https://wrc.dev.begraven.zaakonline.nl/organizations/d736013f-ad6d-4885-b816-ce72ac3e1384'); // Hoorn
    	$scope->addUserGroup($groupBeheer);
    	$manager->persist($scope);

        $manager->flush();
    }
}