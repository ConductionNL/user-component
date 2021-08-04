<?php

namespace App\DataFixtures;

use App\Entity\Group;
use App\Entity\Scope;
use App\Entity\User;
use Conduction\CommonGroundBundle\Service\CommonGroundService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;;

class ZuiddrechtFixtures extends Fixture
{
    private $params;
    private $commonGroundService;
    private $encoder;

    public function __construct(ParameterBagInterface $params, CommonGroundService $commonGroundService, UserPasswordHasherInterface $encoder)
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
            ($this->params->get('app_domain') != 'zuid-drecht.nl' && strpos($this->params->get('app_domain'), 'zuid-drecht.nl') == false)
        ) {
            return false;
        }

        $userTest = new User();
        $userTest->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $userTest->setUsername('test@zuid-drecht.nl');
        $userTest->setPassword($this->encoder->hashPassword($userTest, 'test1234'));
        $manager->persist($userTest);

        $userBeheer = new User();
        $userBeheer->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $userBeheer->setUsername('beheer@zuiddrecht.nl');
        $userBeheer->setPassword($this->encoder->hashPassword($userBeheer, 'test1234'));
        $manager->persist($userBeheer);

        $groupUsers = new Group();
        $groupUsers->setName('Users');
        $groupUsers->setDescription('Alle gebruikers');
        $groupUsers->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $groupUsers->addUser($userBeheer);
        $groupUsers->addUser($userTest);
        $manager->persist($groupUsers);

        $groupBeheer = new Group();
        $groupBeheer->setName('Beheerder');
        $groupBeheer->setDescription('De beheerders die de congiruatie inregelen');
        $groupBeheer->setParent($groupUsers);
        $groupBeheer->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $groupBeheer->addUser($userBeheer);
        $manager->persist($groupBeheer);

        $id = '3ae959d7-01e2-4939-8442-0be4ca8e2898';
        $groupIdin = new Group();
        $groupIdin->setName('Idin');
        $groupIdin->setDescription('Idin gebruikers');
        $groupIdin->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $manager->persist($groupIdin);
        $groupIdin->setId($id);
        $manager->persist($groupIdin);
        $manager->flush();
        $groupIdin = $manager->getRepository('App:Group')->findOneBy(['id' => $id]);

        $scope = new Scope();
        $scope->setName('Medewerkers bewerken');
        $scope->setDescription('Kunnen schrijven op een verzoek');
        $scope->setCode('mrc.employees.write');
        $scope->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        //$scope->setApplication('https://wrc.huwelijksplanner.online/organizations/68b64145-0740-46df-a65a-9d3259c2fec8'); // Utrecht
        $manager->persist($scope);

        $scope = new Scope();
        $scope->setName('Locaties bewerken');
        $scope->setDescription('Kunnen schrijven op een verzoek');
        $scope->setCode('lc.accommodations.write');
        $scope->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        //$scope->setApplication('https://wrc.huwelijksplanner.online/organizations/68b64145-0740-46df-a65a-9d3259c2fec8'); // Utrecht
        $scope->addUserGroup($groupBeheer);
        $manager->persist($scope);

        $scope = new Scope();
        $scope->setName('Plekken bewerken');
        $scope->setDescription('Kunnen schrijven op een verzoek');
        $scope->setCode('lc.places.write');
        $scope->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        //$scope->setApplication('https://wrc.huwelijksplanner.online/organizations/68b64145-0740-46df-a65a-9d3259c2fec8'); // Utrecht
        $scope->addUserGroup($groupBeheer);
        $manager->persist($scope);

        $scope = new Scope();
        $scope->setName('Medewerkers bewerken');
        $scope->setDescription('Kunnen schrijven op een verzoek');
        $scope->setCode('irc.assents.write');
        $scope->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        //$scope->setApplication('https://wrc.huwelijksplanner.online/organizations/68b64145-0740-46df-a65a-9d3259c2fec8'); // Utrecht
        $scope->addUserGroup($groupBeheer);
        $manager->persist($scope);

        $scope = new Scope();
        $scope->setName('Medewerkers bewerken');
        $scope->setDescription('Kunnen schrijven op een verzoek');
        $scope->setCode('uc.users.write');
        $scope->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        //$scope->setApplication('https://wrc.huwelijksplanner.online/organizations/68b64145-0740-46df-a65a-9d3259c2fec8'); // Utrecht
        $scope->addUserGroup($groupBeheer);
        $manager->persist($scope);

        $scope = new Scope();
        $scope->setName('Medewerkers bewerken');
        $scope->setDescription('Kunnen schrijven op een verzoek');
        $scope->setCode('uc.groups.write');
        $scope->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        //$scope->setApplication('https://wrc.huwelijksplanner.online/organizations/68b64145-0740-46df-a65a-9d3259c2fec8'); // Utrecht
        $scope->addUserGroup($groupBeheer);
        $manager->persist($scope);

        $scope = new Scope();
        $scope->setName('Medewerkers bewerken');
        $scope->setDescription('Kunnen schrijven op een verzoek');
        $scope->setCode('uc.scopes.write');
        $scope->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        //$scope->setApplication('https://wrc.huwelijksplanner.online/organizations/68b64145-0740-46df-a65a-9d3259c2fec8'); // Utrecht
        $scope->addUserGroup($groupBeheer);
        $manager->persist($scope);

        //userGroup scopes
        $scope = new Scope();
        $scope->setName('verzoeken bekijken');
        $scope->setDescription('Kunnen bekijken van een verzoek');
        $scope->setCode('vrc.requests.read');
        $scope->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $scope->addUserGroup($groupUsers);
        $manager->persist($scope);

        $scope = new Scope();
        $scope->setName('orders bekijken');
        $scope->setDescription('Kunnen bekijken van een order');
        $scope->setCode('orc.orders.read');
        $scope->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $scope->addUserGroup($groupUsers);
        $manager->persist($scope);

        $scope = new Scope();
        $scope->setName('facturen bekijken');
        $scope->setDescription('Kunnen bekijken van een factuur');
        $scope->setCode('bc.invoices.read');
        $scope->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $scope->addUserGroup($groupUsers);
        $manager->persist($scope);

        $scope = new Scope();
        $scope->setName('instemmingen bekijken');
        $scope->setDescription('Kunnen bekijken van een instemming');
        $scope->setCode('irc.assents.read');
        $scope->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $scope->addUserGroup($groupUsers);
        $manager->persist($scope);

        $scope = new Scope();
        $scope->setName('evenementen bekijken');
        $scope->setDescription('Kunnen bekijken van een evenement');
        $scope->setCode('irc.assents.read');
        $scope->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $scope->addUserGroup($groupUsers);
        $manager->persist($scope);

        //idinGroup
        $scope = new Scope();
        $scope->setName('check-ins bekijken');
        $scope->setDescription('Kunnen bekijken van een check-in');
        $scope->setCode('chin.checkins.read');
        $scope->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $scope->addUserGroup($groupIdin);
        $manager->persist($scope);

        $manager->flush();
    }
}
