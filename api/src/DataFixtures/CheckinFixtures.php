<?php

namespace App\DataFixtures;

use App\Entity\Group;
use App\Entity\Provider;
use App\Entity\Scope;
use App\Entity\User;
use Conduction\CommonGroundBundle\Service\CommonGroundService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CheckinFixtures extends Fixture
{
    private $params;
    private $commonGroundService;
    private $encoder;

    public function __construct(ParameterBagInterface $params, CommonGroundService $commonGroundService, UserPasswordEncoderInterface $encoder)
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

        $userCheckin = new User();
        $userCheckin->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'2106575d-50f3-4f2b-8f0f-a2d6bc188222']));
        $userCheckin->setUsername('jan@zwarteraaf.nl');
        $userCheckin->setPerson($this->commonGroundService->cleanUrl(['component'=>'cc', 'type'=>'people', 'id'=>'25006d28-350a-42e9-b9ed-7afb25d4321d']));
        $userCheckin->setPassword($this->encoder->encodePassword($userCheckin, 'test1234'));
        $manager->persist($userCheckin);

        $userCheckin = new User();
        $userCheckin->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'a9398c45-7497-4dbd-8dd1-1be4f3384ed7']));
        $userCheckin->setUsername('bob@goudlust.nl');
        $userCheckin->setPerson($this->commonGroundService->cleanUrl(['component'=>'cc', 'type'=>'people', 'id'=>'25006d28-350a-42e9-b9ed-7afb25d4321d']));
        $userCheckin->setPassword($this->encoder->encodePassword($userCheckin, 'test1234'));
        $manager->persist($userCheckin);

        $userCheckin = new User();
        $userCheckin->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'8812dc58-6bbe-4028-8e36-96f402bf63dd']));
        $userCheckin->setUsername('mark@dijkzicht.nl');
        $userCheckin->setPerson($this->commonGroundService->cleanUrl(['component'=>'cc', 'type'=>'people', 'id'=>'25006d28-350a-42e9-b9ed-7afb25d4321d']));
        $userCheckin->setPassword($this->encoder->encodePassword($userCheckin, 'test1234'));
        $manager->persist($userCheckin);


        $manager->flush();
    }
}
