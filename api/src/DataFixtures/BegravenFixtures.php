<?php

namespace App\DataFixtures;

use App\Entity\Application;
use App\Entity\Group;
use App\Entity\Scope;
use App\Entity\User;
use Conduction\CommonGroundBundle\Service\CommonGroundService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class BegravenFixtures extends Fixture
{
    private $params;
    private $encoder;

    public function __construct(ParameterBagInterface $params, UserPasswordEncoderInterface $encoder, CommonGroundService $commonGroundService)
    {
        $this->params = $params;
        $this->encoder = $encoder;
        $this->commonGroundService = $commonGroundService;
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
        $application->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'d280c4d3-6310-46db-9934-5285ec7d0d5e']));
        $manager->persist($application);

        $userTest = new User();
        $userTest->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'d736013f-ad6d-4885-b816-ce72ac3e1384'])); // Hoorn
        $userTest->setUsername('test@hoorn.nl');
        $userTest->setPassword($this->encoder->encodePassword($userTest, 'test1234'));
        $manager->persist($userTest);

        $userBalie = new User();
        $userBalie->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'d736013f-ad6d-4885-b816-ce72ac3e1384'])); // Hoorn
        $userBalie->setUsername('balie@hoorn.nl');
        $userBalie->setPassword($this->encoder->encodePassword($userBalie, 'test1234'));
        $manager->persist($userBalie);

        $userLocatie = new User();
        $userLocatie->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'d736013f-ad6d-4885-b816-ce72ac3e1384'])); // Hoorn
        $userLocatie->setUsername('locatie@hoorn.nl');
        $userLocatie->setPassword('test1234');
        $manager->persist($userLocatie);

        $userBeheer = new User();
        $userBeheer->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'d736013f-ad6d-4885-b816-ce72ac3e1384'])); // Hoorn
        $userBeheer->setUsername('beheer@hoorn.nl');
        $userBeheer->setPassword($this->encoder->encodePassword($userBeheer, 'test1234'));
        $manager->persist($userBeheer);

        $userWestfriesland = new User();
        $userWestfriesland->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'d280c4d3-6310-46db-9934-5285ec7d0d5e'])); // Westfriesland
        $userWestfriesland->setUsername('medewerker@westfriesland.nl');
        $userWestfriesland->setPassword($this->encoder->encodePassword($userBeheer, 'test1234'));
        $manager->persist($userWestfriesland);

        $userOpmeer = new User();
        $userOpmeer->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'16fd1092-c4d3-4011-8998-0e15e13239cf'])); // Opmeer
        $userOpmeer->setUsername('medewerker@opmeer.nl');
        $userOpmeer->setPassword($this->encoder->encodePassword($userBeheer, 'test1234'));
        $manager->persist($userOpmeer);

        $userMedemblik = new User();
        $userMedemblik->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'429e66ef-4411-4ddb-8b83-c637b37e88b5'])); // Medemblik
        $userMedemblik->setUsername('medewerker@medemblik.nl');
        $userMedemblik->setPassword($this->encoder->encodePassword($userBeheer, 'test1234'));
        $manager->persist($userMedemblik);

        $userSed = new User();
        $userSed->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'7033eeb4-5c77-4d88-9f40-303b538f176f'])); // SED
        $userSed->setUsername('medewerker@sed.nl');
        $userSed->setPassword($this->encoder->encodePassword($userBeheer, 'test1234'));
        $manager->persist($userSed);

        $userKoggenland = new User();
        $userKoggenland->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'f050292c-973d-46ab-97ae-9d8830a59d15'])); // SED
        $userKoggenland->setUsername('medewerker@koggenland.nl');
        $userKoggenland->setPassword($this->encoder->encodePassword($userBeheer, 'test1234'));
        $manager->persist($userKoggenland);


        // Vortex Adventures
        $groupUsers = new Group();
        $groupUsers->setName('Users');
        $groupUsers->setDescription('Alle gebruikers');
        $groupUsers->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'d736013f-ad6d-4885-b816-ce72ac3e1384'])); // Hoorn
        $groupUsers->addUser($userBalie);
        $groupUsers->addUser($userLocatie);
        $groupUsers->addUser($userBeheer);
        $groupUsers->addUser($userWestfriesland);
        $groupUsers->addUser($userOpmeer);
        $groupUsers->addUser($userMedemblik);
        $groupUsers->addUser($userSed);
        $groupUsers->addUser($userKoggenland);

        $manager->persist($groupUsers);

        $groupBalie = new Group();
        $groupBalie->setName('Begraafplaats Beheerder');
        $groupBalie->setDescription('De balliemedewerkers');
        $groupBalie->setParent($groupUsers);
        $groupBalie->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'d736013f-ad6d-4885-b816-ce72ac3e1384'])); // Hoorn
        $groupBalie->addUser($userBalie);
        $manager->persist($groupBalie);

        $groupLocatie = new Group();
        $groupLocatie->setName('Locatie beheerders');
        $groupLocatie->setDescription('De beheerders van een of meerdere locaties');
        $groupLocatie->setParent($groupUsers);
        $groupLocatie->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'d736013f-ad6d-4885-b816-ce72ac3e1384'])); // Hoorn
        $groupLocatie->addUser($userLocatie);
        $manager->persist($groupLocatie);

        $groupBeheer = new Group();
        $groupBeheer->setName('Beheerder');
        $groupBeheer->setDescription('De beheerders die de congiruatie inregelen');
        $groupBeheer->setParent($groupUsers);
        $groupBeheer->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'d736013f-ad6d-4885-b816-ce72ac3e1384'])); // Hoorn
        $groupBeheer->addUser($userBeheer);
        $manager->persist($groupBeheer);

        $groupBeheer = new Group();
        $groupBeheer->setName('Beheerder');
        $groupBeheer->setDescription('De beheerders die de congiruatie inregelen');
        $groupBeheer->setParent($groupUsers);
        $groupBeheer->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'d280c4d3-6310-46db-9934-5285ec7d0d5e'])); // Westfriesland
        $groupBeheer->addUser($userWestfriesland);
        $manager->persist($groupBeheer);

        $scope = new Scope();
        $scope->setName('Verzoek schrijven');
        $scope->setDescription('Kunnen schrijven op een verzoek');
        $scope->setCode('vrc.request.write');
        $scope->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'d736013f-ad6d-4885-b816-ce72ac3e1384'])); // Hoorn
        $scope->setApplication($application); // Hoorn
        $scope->addUserGroup($groupBeheer);
        $manager->persist($scope);

        $manager->flush();


        // Viava la users

        //  Koggenland
        ///Lydia Braas
        $user = new User();
        $user->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'f050292c-973d-46ab-97ae-9d8830a59d15'])); // SED
        $user->setUsername('l.braas@koggenland.nl');
        $user->setPassword($this->encoder->encodePassword($user, 'test1234'));
        $manager->persist($user);
        $groupUsers->addUser($user);
        $groupBalie->addUser($user);

        ///  opmeer | Mark Dekker
        $user = new User();
        $user->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'16fd1092-c4d3-4011-8998-0e15e13239cf'])); // Opmeer
        $user->setUsername('mdekker@opmeer.nl');
        $user->setPassword($this->encoder->encodePassword($user, 'test1234'));
        $manager->persist($user);
        $groupUsers->addUser($user);
        $groupBalie->addUser($user);

        ///  Medemblik | Paula Aker | Truus Bruinsma-Stapel
        $user = new User();
        $user->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'429e66ef-4411-4ddb-8b83-c637b37e88b5'])); // Medemblik
        $user->setUsername('paula.aker@medemblik.nl');
        $user->setPassword($this->encoder->encodePassword($user, 'test1234'));
        $manager->persist($user);
        $groupUsers->addUser($user);
        $groupBalie->addUser($user);

        $user = new User();
        $user->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'429e66ef-4411-4ddb-8b83-c637b37e88b5'])); // Medemblik
        $user->setUsername('truus.bruinsma@medemblik.nl');
        $user->setPassword($this->encoder->encodePassword($user, 'test1234'));
        $manager->persist($user);
        $groupUsers->addUser($user);
        $groupBalie->addUser($user);


        ///  SED | Peter Bax

        $user = new User();
        $user->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'7033eeb4-5c77-4d88-9f40-303b538f176f'])); // SED
        $user->setUsername('peter.bax@sed-wf.nl');
        $user->setPassword($this->encoder->encodePassword($user, 'test1234'));
        $manager->persist($user);
        $groupUsers->addUser($user);
        $groupBalie->addUser($user);

        ///  Hoorn | Sjerps, Cees | Esther  Kaag - Oud

        $user = new User();
        $user->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'d736013f-ad6d-4885-b816-ce72ac3e1384'])); // Hoorn
        $user->setUsername('c.sjerps@hoorn.nl');
        $user->setPassword($this->encoder->encodePassword($user, 'test1234'));
        $manager->persist($user);
        $groupUsers->addUser($user);
        $groupBalie->addUser($user);

        $user = new User();
        $user->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'d736013f-ad6d-4885-b816-ce72ac3e1384'])); // Hoorn
        $user->setUsername('e.kaag@hoorn.nl');
        $user->setPassword($this->encoder->encodePassword($user, 'test1234'));
        $manager->persist($user);
        $groupUsers->addUser($user);
        $groupBalie->addUser($user);

        $manager->persist($groupUsers);
        $manager->persist($groupBalie);

        $manager->flush();

    }
}
