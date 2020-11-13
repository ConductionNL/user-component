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

class IdVaultFixtures extends Fixture
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
            !$this->params->get('app_build_all_fixtures') &&
            ($this->params->get('app_domain') != 'zuiddrecht.nl' && strpos($this->params->get('app_domain'), 'zuiddrecht.nl') == false) &&
            ($this->params->get('app_domain') != 'zuid-drecht.nl' && strpos($this->params->get('app_domain'), 'zuid-drecht.nl') == false) &&
            ($this->params->get('app_domain') != 'id-vault.com' && strpos($this->params->get('app_domain'), 'id-vault.com') == false)
        ) {
            return false;
        }

        $ruben = new User();
        $ruben->setUsername('ruben@conduction.nl');
        $ruben->setPerson($this->commonGroundService->cleanUrl(['component'=>'cc', 'type'=>'people', 'id'=>'ce49a652-4b0b-4aa7-98a7-ff4a0cc9e33d']));

        if ($this->params->get('app_env') == 'prod') {
            $ruben->setPassword($this->encoder->encodePassword($ruben, bin2hex(openssl_random_pseudo_bytes(4))));
        } else {
            $ruben->setPassword($this->encoder->encodePassword($ruben, 'test1234'));
        }

        $manager->persist($ruben);

        $matthias = new User();
        $matthias->setUsername('matthias@conduction.nl');
        $matthias->setPerson($this->commonGroundService->cleanUrl(['component'=>'cc', 'type'=>'people', 'id'=>'8b97830b-b119-4b58-afcc-f4fe37a1abf8']));

        if ($this->params->get('app_env') == 'prod') {
            $matthias->setPassword($this->encoder->encodePassword($matthias, bin2hex(openssl_random_pseudo_bytes(4))));
        } else {
            $matthias->setPassword($this->encoder->encodePassword($matthias, 'test1234'));
        }

        $manager->persist($matthias);

        $marleen = new User();
        $marleen->setUsername('marleen@conduction.nl');
        $marleen->setPerson($this->commonGroundService->cleanUrl(['component'=>'cc', 'type'=>'people', 'id'=>'d1ad5cec-5cb1-4d0a-ba44-b5363fb7f2f7']));

        if ($this->params->get('app_env') == 'prod') {
            $marleen->setPassword($this->encoder->encodePassword($marleen, bin2hex(openssl_random_pseudo_bytes(4))));
        } else {
            $marleen->setPassword($this->encoder->encodePassword($marleen, 'test1234'));
        }

        $manager->persist($marleen);

        $barry = new User();
        $barry->setUsername('barry@conduction.nl');
        $barry->setPerson($this->commonGroundService->cleanUrl(['component'=>'cc', 'type'=>'people', 'id'=>'1f0bc496-aee3-42f5-8b36-29b119944918']));

        if ($this->params->get('app_env') == 'prod') {
            $barry->setPassword($this->encoder->encodePassword($barry, bin2hex(openssl_random_pseudo_bytes(4))));
        } else {
            $barry->setPassword($this->encoder->encodePassword($barry, 'test1234'));
        }

        $manager->persist($barry);

        $robert = new User();
        $robert->setUsername('robert@conduction.nl');
        $robert->setPerson($this->commonGroundService->cleanUrl(['component'=>'cc', 'type'=>'people', 'id'=>'0f8883ca-9990-4279-9392-50275398adcf']));

        if ($this->params->get('app_env') == 'prod') {
            $robert->setPassword($this->encoder->encodePassword($robert, bin2hex(openssl_random_pseudo_bytes(4))));
        } else {
            $robert->setPassword($this->encoder->encodePassword($robert, 'test1234'));
        }

        $manager->persist($robert);

        $gino = new User();
        $gino->setUsername('gino@conduction.nl');
        $gino->setPerson($this->commonGroundService->cleanUrl(['component'=>'cc', 'type'=>'people', 'id'=>'543d52ea-86dc-429b-bb96-2a9e7b90ada3']));

        if ($this->params->get('app_env') == 'prod') {
            $gino->setPassword($this->encoder->encodePassword($gino, bin2hex(openssl_random_pseudo_bytes(4))));
        } else {
            $gino->setPassword($this->encoder->encodePassword($gino, 'test1234'));
        }

        $manager->persist($gino);

        $wilco = new User();
        $wilco->setUsername('wilco@conduction.nl');
        $wilco->setPerson($this->commonGroundService->cleanUrl(['component'=>'cc', 'type'=>'people', 'id'=>'b2d913f1-9949-4a91-8f6c-e130fc8b243f']));

        if ($this->params->get('app_env') == 'prod') {
            $wilco->setPassword($this->encoder->encodePassword($wilco, bin2hex(openssl_random_pseudo_bytes(4))));
        } else {
            $wilco->setPassword($this->encoder->encodePassword($wilco, 'test1234'));
        }

        $manager->persist($wilco);

        $yorick = new User();
        $yorick->setUsername('yorick@conduction.nl');
        $yorick->setPerson($this->commonGroundService->cleanUrl(['component'=>'cc', 'type'=>'people', 'id'=>'5e619ed6-3c44-45af-928b-660a3f75be6b']));

        if ($this->params->get('app_env') == 'prod') {
            $yorick->setPassword($this->encoder->encodePassword($yorick, bin2hex(openssl_random_pseudo_bytes(4))));
        } else {
            $yorick->setPassword($this->encoder->encodePassword($yorick, 'test1234'));
        }

        $manager->persist($yorick);

        $id = 'c3c463b9-8d39-4cc0-b62c-826d8f5b7d8c';
        $group = new Group();
        $group->setName('developer');
        $group->setDescription('developer opties mogen zien en gebruiken');
        $group->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'360e17fb-1a98-48b7-a2a8-212c79a5f51a']));
        $manager->persist($group);
        $group->setId($id);
        $manager->persist($group);
        $manager->flush();
        $group = $manager->getRepository('App:Group')->findOneBy(['id' => $id]);

        $group->addUser($ruben);
        $group->addUser($matthias);
        $group->addUser($marleen);
        $group->addUser($barry);
        $group->addUser($robert);
        $group->addUser($gino);
        $group->addUser($wilco);
        $group->addUser($yorick);
        $manager->persist($group);
        $manager->flush();

        // Dit is een Group wat eigenlijk een Scope is die users zelf kunnen beïnvloeden door middel van een switch
        $id = 'ff0a0468-3b92-4222-9bca-201df1ab0f42';
        $scopeGroup = new Group();
        $scopeGroup->setName('developer.view');
        $scopeGroup->setDescription('developer opties willen kunnen zien en gebruiken');
        $scopeGroup->setCode('developer.view');
        $scopeGroup->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'360e17fb-1a98-48b7-a2a8-212c79a5f51a']));
        $manager->persist($scopeGroup);
        $scopeGroup->setId($id);
        $manager->persist($scopeGroup);
        $manager->flush();
        $scopeGroup = $manager->getRepository('App:Group')->findOneBy(['id' => $id]);

        $scopeGroup->addUser($ruben);
        $scopeGroup->addUser($matthias);
        $scopeGroup->addUser($marleen);
        $scopeGroup->addUser($barry);
        $scopeGroup->addUser($robert);
        $scopeGroup->addUser($gino);
        $scopeGroup->addUser($wilco);
        $scopeGroup->addUser($yorick);
        $manager->persist($scopeGroup);
        $manager->flush();

        $id = 'f4c3964f-c0a1-482f-a218-080688337c99';
        $group = new Group();
        $group->setName('conduction');
        $group->setDescription('conduction medewerker');
        $group->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'360e17fb-1a98-48b7-a2a8-212c79a5f51a']));
        $manager->persist($group);
        $group->setId($id);
        $manager->persist($group);
        $manager->flush();
        $group = $manager->getRepository('App:Group')->findOneBy(['id' => $id]);

        $group->addUser($ruben);
        $group->addUser($matthias);
        $group->addUser($marleen);
        $group->addUser($barry);
        $group->addUser($robert);
        $group->addUser($gino);
        $group->addUser($wilco);
        $group->addUser($yorick);
        $manager->persist($group);
        $manager->flush();

        //Providers
        $provider = new Provider();
        $provider->setName('facebook');
        $provider->setDescription('facebook');
        $provider->setType('facebook');
        $provider->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $provider->setApplication($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'applications', 'id'=>'22888b97-d12b-4505-9a20-ee9cc148d442']));
        $provider->setConfiguration(['app_id'=>str_replace('\'', '', $this->params->get('facebook_id')), 'secret'=>$this->params->get('facebook_secret')]);
        $manager->persist($provider);

        $provider = new Provider();
        $provider->setName('gmail');
        $provider->setDescription('gmail');
        $provider->setType('gmail');
        $provider->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $provider->setApplication($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'applications', 'id'=>'22888b97-d12b-4505-9a20-ee9cc148d442']));
        $provider->setConfiguration(['app_id'=>$this->params->get('gmail_id'), 'secret'=>$this->params->get('gmail_secret')]);
        $manager->persist($provider);

        $provider = new Provider();
        $provider->setName('token');
        $provider->setDescription('provider for one time tokens');
        $provider->setType('token');
        $provider->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $provider->setApplication($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'applications', 'id'=>'22888b97-d12b-4505-9a20-ee9cc148d442']));
        $manager->persist($provider);

        $provider = new Provider();
        $provider->setName('github');
        $provider->setDescription('github provider');
        $provider->setType('github');
        $provider->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $provider->setApplication($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'applications', 'id'=>'22888b97-d12b-4505-9a20-ee9cc148d442']));
        $manager->persist($provider);

        $provider = new Provider();
        $provider->setName('oauth');
        $provider->setDescription('oauth provider');
        $provider->setType('oauth');
        $provider->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $provider->setApplication($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'applications', 'id'=>'22888b97-d12b-4505-9a20-ee9cc148d442']));
        $manager->persist($provider);

        $manager->flush();
    }
}
