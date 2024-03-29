<?php

namespace App\DataFixtures;

use App\Entity\Application;
use App\Entity\Group;
use App\Entity\Scope;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SHertogenboschFixtures extends Fixture
{
    private $params;
    private $encoder;

    public function __construct(ParameterBagInterface $params, UserPasswordHasherInterface $encoder)
    {
        $this->params = $params;
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        // Lets make sure we only run these fixtures on huwelijksplanner enviroments
        if (
            $this->params->get('app_domain') != 'shertogenbosch.commonground.nu' &&
            strpos($this->params->get('app_domain'), 'shertogenbosch.commonground.nu') == false &&
            $this->params->get('app_domain') != 's-hertogenbosch.commonground.nu' &&
            strpos($this->params->get('app_domain'), 's-hertogenbosch.commonground.nu') == false &&
            $this->params->get('app_domain') != 'verhuizen.accp.s-hertogenbosch.nl' &&
            strpos($this->params->get('app_domain'), 'verhuizen.accp.s-hertogenbosch.nl') == false
        ) {
            return false;
        }

        $application = new Application();
        $application->setName('Begrafenisplanner');
        $application->setDescription('De Westfriesland Begravenapplication');
        $application->setOrganization('http://wrc.dev.westfriesland.commonground.nu/organizations/d280c4d3-6310-46db-9934-5285ec7d0d5e');
        $manager->persist($application);

        $userBalie = new User();
        $userBalie->setOrganization('https://wrc.dev.begraven.zaakonline.nl/organizations/d736013f-ad6d-4885-b816-ce72ac3e1384'); // Hoorn
        $userBalie->setUsername('balie@s-hertogenbosch.nl');
        $userBalie->setPassword($this->encoder->hashPassword($userBalie, 'test1234'));
        $manager->persist($userBalie);

        $userBeheer = new User();
        $userBeheer->setOrganization('https://wrc.dev.begraven.zaakonline.nl/organizations/d736013f-ad6d-4885-b816-ce72ac3e1384'); // Hoorn
        $userBeheer->setUsername('beheer@s-hertogenbosch.nl');
        $userBeheer->setPassword($this->encoder->hashPassword($userBeheer, 'test1234'));
        $manager->persist($userBeheer);

        // Vortex Adventures
        $groupUsers = new Group();
        $groupUsers->setName('Users');
        $groupUsers->setDescription('Alle gebruikers');
        $groupUsers->setOrganization('https://wrc.dev.begraven.zaakonline.nl/organizations/d736013f-ad6d-4885-b816-ce72ac3e1384'); // Hoorn
        $groupUsers->addUser($userBalie);
        $groupUsers->addUser($userBeheer);
        $manager->persist($groupUsers);

        $groupBalie = new Group();
        $groupBalie->setName('Balie Medewerkers');
        $groupBalie->setDescription('De balliemedewerkers');
        $groupBalie->setParent($groupUsers);
        $groupBalie->setOrganization('https://wrc.dev.begraven.zaakonline.nl/organizations/d736013f-ad6d-4885-b816-ce72ac3e1384'); // Hoorn
        $groupBalie->addUser($userBalie);
        $manager->persist($groupBalie);

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
        $scope->setApplication($application); // Hoorn
        $scope->addUserGroup($groupBeheer);
        $manager->persist($scope);

        $manager->flush();
    }
}
