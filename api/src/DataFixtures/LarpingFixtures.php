<?php

namespace App\DataFixtures;

use App\Entity\Group;
use App\Entity\Provider;
use App\Entity\User;
use Conduction\CommonGroundBundle\Service\CommonGroundService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class LarpingFixtures extends Fixture
{
    private $params;
    private $encoder;
    private $commonGroundService;

    public function __construct(ParameterBagInterface $params, UserPasswordEncoderInterface $encoder, CommonGroundService $commonGroundService)
    {
        $this->params = $params;
        $this->encoder = $encoder;
        $this->commonGroundService = $commonGroundService;
    }

    public function load(ObjectManager $manager)
    {
        // Lets make sure we only run these fixtures on larping enviroment
        if (
            !$this->params->get('app_build_all_fixtures') &&
            $this->params->get('app_domain') != 'larping.eu' && strpos($this->params->get('app_domain'), 'larping.eu') == false
        ) {
            return false;
        }

        // Larping provider

        $provider = new Provider();
        $provider->setName('id-vault larping');
        $provider->setDescription('id-vault provider');
        $provider->setType('id-vault');
        $provider->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'7b863976-0fc3-4f49-a4f7-0bf7d2f2f535']));
        $provider->setApplication($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'applications', 'id'=>'9798cae6-187a-434f-bd66-f1dc2cc61466']));
        $provider->setConfiguration(['app_id'=>'5af1e409-3d49-45f9-871b-6e4e35b6f5fc', 'secret'=>'bd4f6884-7819-444f-9968-5f5565029080']);
        $manager->persist($provider);

        $manager->flush();

        $user = new User();
        $user->setOrganization($this->commonGroundService->cleanUrl(['component' => 'wrc', 'type' => 'organizations', 'id' => '7b863976-0fc3-4f49-a4f7-0bf7d2f2f535'])); // Larping
        $user->setUsername('test@larping.eu');
        $user->setPassword($this->encoder->encodePassword($user, 'bierflesje'));
        $manager->persist($user);

        $manager->flush();

    }
}
