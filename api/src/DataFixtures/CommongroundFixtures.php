<?php

namespace App\DataFixtures;

use App\Entity\Provider;
use Conduction\CommonGroundBundle\Service\CommonGroundService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CommongroundFixtures extends Fixture
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
            !$this->params->get('app_build_all_fixtures') &&
            $this->params->get('app_domain') != 'commonground.nu' && strpos($this->params->get('app_domain'), 'commonground.nu') == false) {
            return false;
        }

        // Commonground nu provider
        $provider = new Provider();
        $provider->setName('id-vault');
        $provider->setDescription('id-vault provider');
        $provider->setType('id-vault');
        $provider->setOrganization($this->commonGroundService->cleanUrl(['component' => 'wrc', 'type' => 'organizations', 'id' => '073741b3-f756-4767-aa5d-240f167ca89d']));
        $provider->setApplication($this->commonGroundService->cleanUrl(['component' => 'wrc', 'type' => 'applications', 'id' => '7d19fbc6-6c35-4087-ab10-9778277cefe1']));
        $provider->setConfiguration(['app_id'=>'593867bc-9dfc-4f53-9ee9-abfb278bc42c', 'secret'=>'kjdIDA9al3283hasdnbdDASD84Os2Q']);
        $manager->persist($provider);

        $manager->flush();
    }
}
