<?php

namespace App\DataFixtures;

use App\Entity\Group;
use App\Entity\User;
use Conduction\CommonGroundBundle\Service\CommonGroundService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ConductionFixtures extends Fixture
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
        // Lets make sure we only run these fixtures on larping enviroment
        if ($this->params->get('app_domain') != 'conduction.nl' && strpos($this->params->get('app_domain'), 'conduction.nl') == false) {
            return false;
        }

        $user = new User();
        $user->setOrganization('https://wrc.conduction.nl/organizations/68b64145-0740-46df-a65a-9d3259c2fec8'); // Larping
        $user->setUsername('info@conduction.nl');
        $user->setPassword($this->encoder->hashPassword($user, 'lampenkap'));
        $manager->persist($user);

        // Larping
        $groupUsers = new Group();
        $groupUsers->setName('Users');
        $groupUsers->setDescription('The general User group');
        $groupUsers->setOrganization('https://wrc.conduction.nl/organizations/organizations/39405560-7859-4d16-943b-042d6c053a0f'); // Larping
        $groupUsers->addUser($user);
        $manager->persist($groupUsers);

        $groupBeheer = new Group();
        $groupBeheer->setName('Beheerders');
        $groupBeheer->setDescription('De beheerders die de configuratie inregelen');
        $groupBeheer->setParent($groupUsers);
        $groupBeheer->setOrganization('https://wrc.conduction.nl/organizations/organizations/39405560-7859-4d16-943b-042d6c053a0f'); // Utrecht
        $groupBeheer->addUser($user);
        $manager->persist($groupBeheer);

        //Stage
        //Test Student User
        $testStudent = new User();
        $testStudent->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'6a001c4c-911b-4b29-877d-122e362f519d'])); // Conduction
        $testStudent->setUsername('testStudent');
        $testStudent->setPassword($this->encoder->hashPassword($testStudent, 'test1234'));
        $manager->persist($testStudent);

        //Group Studenten
        $groupStudenten = new Group();
        $groupStudenten->setName('Studenten');
        $groupStudenten->setDescription('Alle studenten');
        $groupStudenten->setTitle('Student');
        $groupStudenten->setCanBeRegisteredFor(true);
        $groupStudenten->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'6a001c4c-911b-4b29-877d-122e362f519d'])); // Conduction
        $groupStudenten->addUser($testStudent);
        $manager->persist($groupStudenten);

        //Test Bedrijf User
        $testBedrijf = new User();
        $testBedrijf->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'6a001c4c-911b-4b29-877d-122e362f519d'])); // Conduction
        $testBedrijf->setUsername('testBedrijf');
        $testBedrijf->setPassword($this->encoder->hashPassword($testBedrijf, 'test1234'));
        $manager->persist($testBedrijf);

        //Group Bedrijven
        $groupBedrijven = new Group();
        $groupBedrijven->setName('Bedrijven');
        $groupBedrijven->setDescription('Alle bedrijven');
        $groupBedrijven->setTitle('Bedrijf');
        $groupBedrijven->setCanBeRegisteredFor(true);
        $groupBedrijven->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'6a001c4c-911b-4b29-877d-122e362f519d'])); // Conduction
        $groupBedrijven->addUser($testBedrijf);
        $manager->persist($groupBedrijven);

        $manager->flush();
    }
}
