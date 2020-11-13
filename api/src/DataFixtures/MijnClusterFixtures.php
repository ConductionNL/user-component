<?php

namespace App\DataFixtures;

use App\Entity\Group;
use App\Entity\Scope;
use App\Entity\User;
use Conduction\CommonGroundBundle\Service\CommonGroundService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class MijnClusterFixtures extends Fixture
{
    private $commonGroundService;
    private $params;
    private $encoder;

    public function __construct(CommonGroundService $commonGroundService, ParameterBagInterface $params, UserPasswordEncoderInterface $encoder)
    {
        $this->commonGroundService = $commonGroundService;
        $this->params = $params;
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        // Lets make sure we only run these fixtures on larping enviroment
        if ($this->params->get('app_domain') != 'mijncluster.nl' && strpos($this->params->get('app_domain'), 'mijncluster.nl') == false) {
            return false;
        }

        $user = new User();
        $user->setOrganization("{$this->commonGroundService->getComponent('wrc')['location']}/organizations/cc935415-a674-4235-b99d-0c7bfce5c7aa"); // Pink Rocade
        $user->setUsername('beheer@pinkroccade.nl');
        $user->setPassword($this->encoder->encodePassword($userBeheer, '$user'));
        $manager->persist($user);

        // Pink Rocade
        $groupUsers = new Group();
        $groupUsers->setName('Users');
        $groupUsers->setDescription('Alle gebruikers');
        $groupUsers->setOrganization("{$this->commonGroundService->getComponent('wrc')['location']}/organizations/cc935415-a674-4235-b99d-0c7bfce5c7aa"); // Pink Rocade
        $groupUsers->addUser($user);
        $manager->persist($groupUsers);

        $groupBeheer = new Group();
        $groupBeheer->setName('Beheerder');
        $groupBeheer->setDescription('De beheerders die de configuratie inregelen');
        $groupBeheer->setParent($groupUsers);
        $groupBeheer->setOrganization("{$this->commonGroundService->getComponent('wrc')['location']}/organizations/cc935415-a674-4235-b99d-0c7bfce5c7aa"); // Pink Rocade
        $groupBeheer->addUser($user);
        $manager->persist($groupBeheer);

        $scope = new Scope();
        $scope->setName('Medewerkers bewerken');
        $scope->setDescription('Kunnen schrijven op een verzoek');
        $scope->setCode('mrc.employees.write');
        $scope->setOrganization("{$this->commonGroundService->getComponent('wrc')['location']}/organizations/cc935415-a674-4235-b99d-0c7bfce5c7aa"); // Pink Rocade
        $manager->persist($scope);

        $scope = new Scope();
        $scope->setName('Locaties bewerken');
        $scope->setDescription('Kunnen schrijven op een verzoek');
        $scope->setCode('lc.accommodations.write');
        $scope->setOrganization("{$this->commonGroundService->getComponent('wrc')['location']}/organizations/cc935415-a674-4235-b99d-0c7bfce5c7aa"); // Pink Rocade
        $scope->addUserGroup($groupBeheer);
        $scope->addUserGroup($groupLocatie);
        $manager->persist($scope);

        $scope = new Scope();
        $scope->setName('Plekken bewerken');
        $scope->setDescription('Kunnen schrijven op een verzoek');
        $scope->setCode('lc.places.write');
        $scope->setOrganization("{$this->commonGroundService->getComponent('wrc')['location']}/organizations/cc935415-a674-4235-b99d-0c7bfce5c7aa"); // Pink Rocade
        $scope->addUserGroup($groupBeheer);
        $scope->addUserGroup($groupLocatie);
        $manager->persist($scope);

        $scope = new Scope();
        $scope->setName('Medewerkers bewerken');
        $scope->setDescription('Kunnen schrijven op een verzoek');
        $scope->setCode('irc.assents.write');
        $scope->setOrganization("{$this->commonGroundService->getComponent('wrc')['location']}/organizations/cc935415-a674-4235-b99d-0c7bfce5c7aa"); // Pink Rocade
        $scope->addUserGroup($groupBeheer);
        $scope->addUserGroup($groupBalie);
        $manager->persist($scope);

        $scope = new Scope();
        $scope->setName('Medewerkers bewerken');
        $scope->setDescription('Kunnen schrijven op een verzoek');
        $scope->setCode('uc.users.write');
        $scope->setOrganization("{$this->commonGroundService->getComponent('wrc')['location']}/organizations/cc935415-a674-4235-b99d-0c7bfce5c7aa"); // Pink Rocade
        $scope->addUserGroup($groupBeheer);
        $manager->persist($scope);

        $scope = new Scope();
        $scope->setName('Medewerkers bewerken');
        $scope->setDescription('Kunnen schrijven op een verzoek');
        $scope->setCode('uc.groups.write');
        $scope->setOrganization("{$this->commonGroundService->getComponent('wrc')['location']}/organizations/cc935415-a674-4235-b99d-0c7bfce5c7aa"); // Pink Rocade
        $scope->addUserGroup($groupBeheer);
        $manager->persist($scope);

        $scope = new Scope();
        $scope->setName('Medewerkers bewerken');
        $scope->setDescription('Kunnen schrijven op een verzoek');
        $scope->setCode('uc.scopes.write');
        $scope->setOrganization("{$this->commonGroundService->getComponent('wrc')['location']}/organizations/cc935415-a674-4235-b99d-0c7bfce5c7aa"); // Pink Rocade
        $scope->addUserGroup($groupBeheer);
        $manager->persist($scope);

        $manager->flush();
    }
}
