<?php

namespace App\DataFixtures;

use App\Entity\Group;
use App\Entity\Scope;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class HuwelijksplannerFixtures extends Fixture
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
        if ($this->params->get('app_domain') != 'huwelijksplanner.online' && strpos($this->params->get('app_domain'), 'huwelijksplanner.online') == false) {
            return false;
        }

        $userTest = new User();
        $userTest->setOrganization('https://wrc.huwelijksplanner.online/organizations/68b64145-0740-46df-a65a-9d3259c2fec8'); // Utrecht
        $userTest->setUsername('test@utrecht.nl');
        $userTest->setPassword($this->encoder->hashPassword($userTest, 'test1234'));
        $manager->persist($userTest);

        $userBalie = new User();
        $userBalie->setOrganization('https://wrc.huwelijksplanner.online/organizations/68b64145-0740-46df-a65a-9d3259c2fec8'); // Utrecht
        $userBalie->setUsername('balie@utrecht.nl');
        $userBalie->setPassword($this->encoder->hashPassword($userBalie, 'test1234'));
        $manager->persist($userBalie);

        $userLocatie = new User();
        $userLocatie->setOrganization('https://wrc.huwelijksplanner.online/organizations/68b64145-0740-46df-a65a-9d3259c2fec8'); // Utrecht
        $userLocatie->setUsername('locatie@utrecht.nl');
        $userLocatie->setPassword('test1234');
        $manager->persist($userLocatie);

        $usertTrouwambtenaar = new User();
        $usertTrouwambtenaar->setOrganization('https://wrc.huwelijksplanner.online/organizations/68b64145-0740-46df-a65a-9d3259c2fec8'); // Utrecht
        $usertTrouwambtenaar->setUsername('trouwambtenaar@utrecht.nl');
        $usertTrouwambtenaar->setPassword($this->encoder->hashPassword($usertTrouwambtenaar, 'test1234'));
        $manager->persist($usertTrouwambtenaar);

        $userBeheer = new User();
        $userBeheer->setOrganization('https://wrc.huwelijksplanner.online/organizations/68b64145-0740-46df-a65a-9d3259c2fec8'); // Utrecht
        $userBeheer->setUsername('beheer@utrecht.nl');
        $userBeheer->setPassword($this->encoder->hashPassword($userBeheer, 'test1234'));
        $manager->persist($userBeheer);

        // Vortex Adventures
        $groupUsers = new Group();
        $groupUsers->setName('Users');
        $groupUsers->setDescription('Alle gebruikers');
        $groupUsers->setOrganization('https://wrc.huwelijksplanner.online/organizations/68b64145-0740-46df-a65a-9d3259c2fec8'); // Utrecht
        $groupUsers->addUser($userBalie);
        $groupUsers->addUser($userLocatie);
        $groupUsers->addUser($usertTrouwambtenaar);
        $groupUsers->addUser($userBeheer);
        $groupUsers->addUser($userTest);
        $manager->persist($groupUsers);

        $groupBalie = new Group();
        $groupBalie->setName('Balie Medewerkers');
        $groupBalie->setDescription('De balliemedewerkers');
        $groupBalie->setParent($groupUsers);
        $groupBalie->setOrganization('https://wrc.huwelijksplanner.online/organizations/68b64145-0740-46df-a65a-9d3259c2fec8'); // Utrecht
        $groupBalie->addUser($userBalie);
        $groupBalie->addUser($userTest);
        $manager->persist($groupBalie);

        $groupLocatie = new Group();
        $groupLocatie->setName('Locatie beheerders');
        $groupLocatie->setDescription('De hbeheerders van een of meerdere locaties');
        $groupLocatie->setParent($groupUsers);
        $groupLocatie->setOrganization('https://wrc.huwelijksplanner.online/organizations/68b64145-0740-46df-a65a-9d3259c2fec8'); // Utrecht
        $groupLocatie->addUser($userLocatie);
        $groupLocatie->addUser($userTest);
        $manager->persist($groupLocatie);

        $groupTrouwambtenaar = new Group();
        $groupTrouwambtenaar->setName('Trouw Ambtenaar');
        $groupTrouwambtenaar->setDescription('De ambtenaren die het huwelijk voltrekken');
        $groupTrouwambtenaar->setParent($groupUsers);
        $groupTrouwambtenaar->setOrganization('https://wrc.huwelijksplanner.online/organizations/68b64145-0740-46df-a65a-9d3259c2fec8'); // Utrecht
        $groupTrouwambtenaar->addUser($usertTrouwambtenaar);
        $groupTrouwambtenaar->addUser($userTest);
        $manager->persist($groupTrouwambtenaar);

        $groupBeheer = new Group();
        $groupBeheer->setName('Beheerder');
        $groupBeheer->setDescription('De beheerders die de congiruatie inregelen');
        $groupBeheer->setParent($groupUsers);
        $groupBeheer->setOrganization('https://wrc.huwelijksplanner.online/organizations/68b64145-0740-46df-a65a-9d3259c2fec8'); // Utrecht
        $groupBeheer->addUser($userBeheer);
        $groupBeheer->addUser($userTest);
        $manager->persist($groupBeheer);

        $scope = new Scope();
        $scope->setName('Medewerkers bewerken');
        $scope->setDescription('Kunnen schrijven op een verzoek');
        $scope->setCode('mrc.employees.write');
        $scope->setOrganization('https://wrc.huwelijksplanner.online/organizations/68b64145-0740-46df-a65a-9d3259c2fec8'); // Utrecht
        //$scope->setApplication('https://wrc.huwelijksplanner.online/organizations/68b64145-0740-46df-a65a-9d3259c2fec8'); // Utrecht
        $manager->persist($scope);

        $scope = new Scope();
        $scope->setName('Locaties bewerken');
        $scope->setDescription('Kunnen schrijven op een verzoek');
        $scope->setCode('lc.accommodations.write');
        $scope->setOrganization('https://wrc.huwelijksplanner.online/organizations/68b64145-0740-46df-a65a-9d3259c2fec8'); // Utrecht
        //$scope->setApplication('https://wrc.huwelijksplanner.online/organizations/68b64145-0740-46df-a65a-9d3259c2fec8'); // Utrecht
        $scope->addUserGroup($groupBeheer);
        $scope->addUserGroup($groupLocatie);
        $manager->persist($scope);

        $scope = new Scope();
        $scope->setName('Plekken bewerken');
        $scope->setDescription('Kunnen schrijven op een verzoek');
        $scope->setCode('lc.places.write');
        $scope->setOrganization('https://wrc.huwelijksplanner.online/organizations/68b64145-0740-46df-a65a-9d3259c2fec8'); // Utrecht
        //$scope->setApplication('https://wrc.huwelijksplanner.online/organizations/68b64145-0740-46df-a65a-9d3259c2fec8'); // Utrecht
        $scope->addUserGroup($groupBeheer);
        $scope->addUserGroup($groupLocatie);
        $manager->persist($scope);

        $scope = new Scope();
        $scope->setName('Medewerkers bewerken');
        $scope->setDescription('Kunnen schrijven op een verzoek');
        $scope->setCode('irc.assents.write');
        $scope->setOrganization('https://wrc.huwelijksplanner.online/organizations/68b64145-0740-46df-a65a-9d3259c2fec8'); // Utrecht
        //$scope->setApplication('https://wrc.huwelijksplanner.online/organizations/68b64145-0740-46df-a65a-9d3259c2fec8'); // Utrecht
        $scope->addUserGroup($groupBeheer);
        $scope->addUserGroup($groupBalie);
        $manager->persist($scope);

        $scope = new Scope();
        $scope->setName('Medewerkers bewerken');
        $scope->setDescription('Kunnen schrijven op een verzoek');
        $scope->setCode('uc.users.write');
        $scope->setOrganization('https://wrc.huwelijksplanner.online/organizations/68b64145-0740-46df-a65a-9d3259c2fec8'); // Utrecht
        //$scope->setApplication('https://wrc.huwelijksplanner.online/organizations/68b64145-0740-46df-a65a-9d3259c2fec8'); // Utrecht
        $scope->addUserGroup($groupBeheer);
        $manager->persist($scope);

        $scope = new Scope();
        $scope->setName('Medewerkers bewerken');
        $scope->setDescription('Kunnen schrijven op een verzoek');
        $scope->setCode('uc.groups.write');
        $scope->setOrganization('https://wrc.huwelijksplanner.online/organizations/68b64145-0740-46df-a65a-9d3259c2fec8'); // Utrecht
        //$scope->setApplication('https://wrc.huwelijksplanner.online/organizations/68b64145-0740-46df-a65a-9d3259c2fec8'); // Utrecht
        $scope->addUserGroup($groupBeheer);
        $manager->persist($scope);

        $scope = new Scope();
        $scope->setName('Medewerkers bewerken');
        $scope->setDescription('Kunnen schrijven op een verzoek');
        $scope->setCode('uc.scopes.write');
        $scope->setOrganization('https://wrc.huwelijksplanner.online/organizations/68b64145-0740-46df-a65a-9d3259c2fec8'); // Utrecht
        //$scope->setApplication('https://wrc.huwelijksplanner.online/organizations/68b64145-0740-46df-a65a-9d3259c2fec8'); // Utrecht
        $scope->addUserGroup($groupBeheer);
        $manager->persist($scope);

        $manager->flush();
    }
}
