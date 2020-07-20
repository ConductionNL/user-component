<?php

namespace App\DataFixtures;

use App\Entity\Application;
use App\Entity\Group;
use App\Entity\Scope;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
        if (
            $this->params->get('app_domain') != 'begraven.zaakonline.nl' &&
            strpos($this->params->get('app_domain'), 'begraven.zaakonline.nl') == false &&
            $this->params->get('app_domain') != 'westfriesland.commonground.nu' &&
            strpos($this->params->get('app_domain'), 'westfriesland.commonground.nu') == false
        ) {
            return false;
        }

        $application = new Application();
        $application->setName('Begrafenisplanner');
        $application->setDescription('De Westfriesland Begravenapplication');
        $application->setOrganization('http://wrc.dev.westfriesland.commonground.nu/organizations/d280c4d3-6310-46db-9934-5285ec7d0d5e');
        $manager->persist($application);

        $userTest = new User();
        $userTest->setOrganization('https://wrc.westfriesland.commonground.nu/organizations/d736013f-ad6d-4885-b816-ce72ac3e1384'); // Hoorn
        $userTest->setUsername('test@hoorn.nl');
        $userTest->setPassword($this->encoder->encodePassword($userTest, 'test1234'));
        $manager->persist($userTest);

        $userBalie = new User();
        $userBalie->setOrganization('https://wrc.westfriesland.commonground.nu/organizations/d736013f-ad6d-4885-b816-ce72ac3e1384'); // Hoorn
        $userBalie->setUsername('balie@hoorn.nl');
        $userBalie->setPassword($this->encoder->encodePassword($userBalie, 'test1234'));
        $manager->persist($userBalie);

        $userLocatie = new User();
        $userLocatie->setOrganization('https://wrc.westfriesland.commonground.nu/organizations/d736013f-ad6d-4885-b816-ce72ac3e1384'); // Hoorn
        $userLocatie->setUsername('locatie@hoorn.nl');
        $userLocatie->setPassword('test1234');
        $manager->persist($userLocatie);

        $usertTrouwambtenaar = new User();
        $usertTrouwambtenaar->setOrganization('https://wrc.westfriesland.commonground.nu/organizations/d736013f-ad6d-4885-b816-ce72ac3e1384'); // Hoorn
        $usertTrouwambtenaar->setUsername('trouwambtenaar@hoorn.nl');
        $usertTrouwambtenaar->setPassword($this->encoder->encodePassword($usertTrouwambtenaar, 'test1234'));
        $manager->persist($usertTrouwambtenaar);

        $userBeheer = new User();
        $userBeheer->setOrganization('https://wrc.westfriesland.commonground.nu/organizations/d736013f-ad6d-4885-b816-ce72ac3e1384'); // Hoorn
        $userBeheer->setUsername('beheer@hoorn.nl');
        $userBeheer->setPassword($this->encoder->encodePassword($userBeheer, 'test1234'));
        $manager->persist($userBeheer);

        // Vortex Adventures
        $groupUsers = new Group();
        $groupUsers->setName('Users');
        $groupUsers->setDescription('Alle gebruikers');
        $groupUsers->setOrganization('https://wrc.westfriesland.commonground.nu/organizations/d736013f-ad6d-4885-b816-ce72ac3e1384'); // Hoorn
        $groupUsers->addUser($userBalie);
        $groupUsers->addUser($userLocatie);
        $groupUsers->addUser($usertTrouwambtenaar);
        $groupUsers->addUser($userBeheer);
        $manager->persist($groupUsers);

        $groupBalie = new Group();
        $groupBalie->setName('Balie Medewerkers');
        $groupBalie->setDescription('De balliemedewerkers');
        $groupBalie->setParent($groupUsers);
        $groupBalie->setOrganization('https://wrc.westfriesland.commonground.nu/organizations/d736013f-ad6d-4885-b816-ce72ac3e1384'); // Hoorn
        $groupBalie->addUser($userBalie);
        $manager->persist($groupBalie);

        $groupLocatie = new Group();
        $groupLocatie->setName('Locatie beheerders');
        $groupLocatie->setDescription('De hbeheerders van een of meerdere locaties');
        $groupLocatie->setParent($groupUsers);
        $groupLocatie->setOrganization('https://wrc.westfriesland.commonground.nu/organizations/d736013f-ad6d-4885-b816-ce72ac3e1384'); // Hoorn
        $groupLocatie->addUser($userLocatie);
        $manager->persist($groupLocatie);

        $groupTrouwambtenaar = new Group();
        $groupTrouwambtenaar->setName('Trouw Ambtenaar');
        $groupTrouwambtenaar->setDescription('De ambtenaren die het huwelijk voltrekken');
        $groupTrouwambtenaar->setParent($groupUsers);
        $groupTrouwambtenaar->setOrganization('https://wrc.westfriesland.commonground.nu/organizations/d736013f-ad6d-4885-b816-ce72ac3e1384'); // Hoorn
        $groupTrouwambtenaar->addUser($usertTrouwambtenaar);
        $manager->persist($groupTrouwambtenaar);

        $groupBeheer = new Group();
        $groupBeheer->setName('Beheerder');
        $groupBeheer->setDescription('De beheerders die de congiruatie inregelen');
        $groupBeheer->setParent($groupUsers);
        $groupBeheer->setOrganization('https://wrc.westfriesland.commonground.nu/organizations/d736013f-ad6d-4885-b816-ce72ac3e1384'); // Hoorn
        $groupBeheer->addUser($userBeheer);
        $manager->persist($groupBeheer);

        $scope = new Scope();
        $scope->setName('Verzoek schrijven');
        $scope->setDescription('Kunnen schrijven op een verzoek');
        $scope->setCode('vrc.request.write');
        $scope->setOrganization('https://wrc.westfriesland.commonground.nu/organizations/d736013f-ad6d-4885-b816-ce72ac3e1384'); // Hoorn
        $scope->setApplication($application); // Hoorn
        $scope->addUserGroup($groupBeheer);
        $manager->persist($scope);

        $manager->flush();
    }
}
