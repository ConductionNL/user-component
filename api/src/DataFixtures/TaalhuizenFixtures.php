<?php

namespace App\DataFixtures;

use App\Entity\Group;
use App\Entity\Scope;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class TaalhuizenFixtures extends Fixture
{
    private $params;
    private EntityManagerInterface $em;

    public function __construct(ParameterBagInterface $params, EntityManagerInterface $em)
    {
        $this->params = $params;
        $this->em = $em;
    }

    public function load(ObjectManager $manager)
    {
        // Lets make sure we only run these fixtures on larping enviroment
        if (
            !$this->params->get('app_build_all_fixtures') &&
            $this->params->get('app_domain') != 'taalhuizen-bisc.commonground.nu' && strpos($this->params->get('app_domain'), 'taalhuizen-bisc.commonground.nu') == false
        ) {
            return false;
        }

        //groups

        $id = Uuid::fromString('4bb4d846-a263-45c7-8cb7-4e88c81a01ef');
        $admin = new Group();
        $admin->setName('admin');
        $admin->setDescription('admin group');
        $admin->setOrganization('https://taalhuizen-bisc.commonground.nu/api/v1/wrc/organizations/008750e5-0424-440e-aea0-443f7875fbfe');
        $manager->persist($admin);
        $admin->setId($id);
        $manager->persist($admin);
        $manager->flush();
        $admin = $manager->getRepository('App:Group')->findOneBy(['id'=> $id]);

        //users

        $user = new User();
        $user->setUsername('rick@lifely.nl');
        $user->setPassword('f8&VA!l14Vzj');
        $user->setPerson('https://taalhuizen-bisc.commonground.nu/api/v1/cc/people/62bc09d3-2f34-4fa4-880c-da6adec9569f');
        $user->addUserGroup($admin);
        $manager->persist($user);
        $manager->flush();

        $user = new User();
        $user->setUsername('main+testadmin@conduction.nl');
        $user->setPassword('Test1234');
        $user->setPerson('https://taalhuizen-bisc.commonground.nu/api/v1/cc/people/8001c512-e65a-480d-8f2f-84ca3a6a07ce');
        $user->addUserGroup($admin);
        $manager->persist($user);
        $manager->flush();

        //scopes
        //users
        $id = Uuid::fromString('35b916c9-ed5b-4d7f-9a4f-4f226c285adc');
        $scope = new Scope();

        $scope->setName('users update');
        $scope->setCode('users.update');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('671df099-3fed-4b63-a248-128fd15e4845');
        $scope = new Scope();

        $scope->setName('users delete');
        $scope->setCode('users.delete');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('e42a84ff-636c-4b74-85ee-6cac4badfd26');
        $scope = new Scope();

        $scope->setName('users write');
        $scope->setCode('users.write');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('a7d33324-0871-43ef-9bcb-206b3a06a454');
        $scope = new Scope();

        $scope->setName('users read');
        $scope->setCode('users.read');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('295cff69-8d6a-46b3-8eda-508370301184');
        $scope = new Scope();

        $scope->setName('users overview');
        $scope->setCode('users.overview');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        //test results
        $id = Uuid::fromString('2ccf95b1-72b1-4b51-974c-819aa5ca7555');
        $scope = new Scope();

        $scope->setName('test results update');
        $scope->setCode('test.results.update');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('82b9d992-c661-499a-a862-cea8f0e7e0c4');
        $scope = new Scope();

        $scope->setName('test results delete');
        $scope->setCode('test.results.delete');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('bfd55cd2-f4ac-4478-8342-c8732b67d357');
        $scope = new Scope();

        $scope->setName('test results write');
        $scope->setCode('test.results.write');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('516f81fd-effb-432e-8158-56cbbe9cf2f6');
        $scope = new Scope();

        $scope->setName('test results read');
        $scope->setCode('test.results.read');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('1c5f09ef-f4a1-4274-abb6-33e217116422');
        $scope = new Scope();

        $scope->setName('test results overview');
        $scope->setCode('test.results.overview');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        //student referrers
        $id = Uuid::fromString('361e09ed-5a96-4367-9ef7-436444cfa3f0');
        $scope = new Scope();

        $scope->setName('student referrers update');
        $scope->setCode('student.referrers.update');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('87fcbe9a-045e-4739-a9c7-bb98bee8ece4');
        $scope = new Scope();

        $scope->setName('student referrers delete');
        $scope->setCode('student.referrers.delete');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('540135cb-f09d-4475-974b-f86ae7afa780');
        $scope = new Scope();

        $scope->setName('student referrers write');
        $scope->setCode('student.referrers.write');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('4e7901d7-ad2b-49a1-8f1f-7335149fd7a1');
        $scope = new Scope();

        $scope->setName('student referrers read');
        $scope->setCode('student.referrers.read');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('ffc79316-ca0c-4c93-ac3b-bef50f9e2b83');
        $scope = new Scope();

        $scope->setName('student referrers overview');
        $scope->setCode('student.referrers.overview');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        //student people
        $id = Uuid::fromString('defa6dd2-79c3-46a8-9f08-dddddcdd67de');
        $scope = new Scope();

        $scope->setName('student people update');
        $scope->setCode('student.people.update');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('493669ea-05bd-4622-8f33-7589b896199b');
        $scope = new Scope();

        $scope->setName('student people delete');
        $scope->setCode('student.people.delete');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('afdea393-41b7-47f3-b0a0-6beff198baca');
        $scope = new Scope();

        $scope->setName('student people write');
        $scope->setCode('student.people.write');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('9ee7a26f-a39d-4c26-9c3d-ec17b5d2e990');
        $scope = new Scope();

        $scope->setName('student people read');
        $scope->setCode('student.people.read');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('91b38c39-0eba-4ac8-b8fc-ab0ff9687ab6');
        $scope = new Scope();

        $scope->setName('student people overview');
        $scope->setCode('student.people.overview');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        //student permissions
        $id = Uuid::fromString('660c03ed-497a-4486-922c-8394f9c7fc16');
        $scope = new Scope();

        $scope->setName('student permissions update');
        $scope->setCode('student.permissions.update');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('99b80b81-e5c8-4661-84a7-1d435313ce1e');
        $scope = new Scope();

        $scope->setName('student permissions delete');
        $scope->setCode('student.permissions.delete');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('a690255e-2c7c-48b9-b46d-88c6c650efa7');
        $scope = new Scope();

        $scope->setName('student permissions write');
        $scope->setCode('student.permissions.write');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('48666185-4a43-49ab-92ce-85670069a363');
        $scope = new Scope();

        $scope->setName('student permissions read');
        $scope->setCode('student.permissions.read');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('dd140d9d-978f-4956-a19d-7de95bbe8111');
        $scope = new Scope();

        $scope->setName('student permissions overview');
        $scope->setCode('student.permissions.overview');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        //student motivations
        $id = Uuid::fromString('09a49c3e-e6d2-49af-887d-81a7faf9bac3');
        $scope = new Scope();

        $scope->setName('student motivations update');
        $scope->setCode('student.motivations.update');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('ec8623da-30cf-4f94-93fa-7c997330c4ae');
        $scope = new Scope();

        $scope->setName('student motivations delete');
        $scope->setCode('student.motivations.delete');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('6642e8c5-60a5-4e07-9cfa-21048db5ebd4');
        $scope = new Scope();

        $scope->setName('student motivations write');
        $scope->setCode('student.motivations.write');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('fc565419-7f3e-408b-9e4a-d40215e94225');
        $scope = new Scope();

        $scope->setName('student motivations read');
        $scope->setCode('student.motivations.read');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('3245bb38-d70c-4841-9faf-4b7f380cd5e2');
        $scope = new Scope();

        $scope->setName('student motivations overview');
        $scope->setCode('student.motivations.overview');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        //student jobs
        $id = Uuid::fromString('8db703d6-921c-45ac-b63b-7851f295884a');
        $scope = new Scope();

        $scope->setName('student jobs update');
        $scope->setCode('student.jobs.update');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('c0c36763-6f85-457c-a4b3-0f65a8b5a388');
        $scope = new Scope();

        $scope->setName('student jobs delete');
        $scope->setCode('student.jobs.delete');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('062f7ee3-1dee-4974-a4a4-290cd7b292a8');
        $scope = new Scope();

        $scope->setName('student jobs write');
        $scope->setCode('student.jobs.write');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('bfc4478a-1442-474a-ae8c-5a77dff07de7');
        $scope = new Scope();

        $scope->setName('student jobs read');
        $scope->setCode('student.jobs.read');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('b9480a89-7cc7-4bf9-a78e-5344d2e00fdf');
        $scope = new Scope();

        $scope->setName('student jobs overview');
        $scope->setCode('student.jobs.overview');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        //student intake details
        $id = Uuid::fromString('4d084f44-7f39-4e6c-8151-79939e8fea1f');
        $scope = new Scope();

        $scope->setName('student intake details update');
        $scope->setCode('student.intake.details.update');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('28b45c92-434c-4515-b94c-a65281861594');
        $scope = new Scope();

        $scope->setName('student intake details delete');
        $scope->setCode('student.intake.details.delete');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('c973c354-8382-46cd-a456-79a7522e7b59');
        $scope = new Scope();

        $scope->setName('student intake details write');
        $scope->setCode('student.intake.details.write');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('1e74f5b3-b0ed-4b8f-ac0f-7f253cd4e58e');
        $scope = new Scope();

        $scope->setName('student intake details read');
        $scope->setCode('student.intake.details.read');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('08254f2a-9f80-4a9b-90e6-21a07c3b6fd1');
        $scope = new Scope();

        $scope->setName('student intake details overview');
        $scope->setCode('student.intake.details.overview');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        //student generals
        $id = Uuid::fromString('8d7b0621-0671-4da4-a05d-523330ee4fdf');
        $scope = new Scope();

        $scope->setName('student generals update');
        $scope->setCode('student.generals.update');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('242c1a1c-5107-403c-9c01-03a8fbdf03c0');
        $scope = new Scope();

        $scope->setName('student generals delete');
        $scope->setCode('student.generals.delete');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('8e982599-dada-44a3-b50f-4c931618cb61');
        $scope = new Scope();

        $scope->setName('student generals write');
        $scope->setCode('student.generals.write');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('ddac60c3-9bb3-4271-8635-a573649ceadb');
        $scope = new Scope();

        $scope->setName('student generals read');
        $scope->setCode('student.generals.read');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('610884cd-07a6-4497-acba-d3165238b3fa');
        $scope = new Scope();

        $scope->setName('student generals overview');
        $scope->setCode('student.generals.overview');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        //student educations
        $id = Uuid::fromString('b14097c6-2682-4475-94ea-203570153e7c');
        $scope = new Scope();

        $scope->setName('student educations update');
        $scope->setCode('student.educations.update');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('03ddf803-024a-46c2-9905-2d632d91098e');
        $scope = new Scope();

        $scope->setName('student educations delete');
        $scope->setCode('student.educations.delete');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('a33fa775-378e-4803-9658-159a2e7f5c47');
        $scope = new Scope();

        $scope->setName('student educations write');
        $scope->setCode('student.educations.write');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('d07d4fca-9b70-4830-ba9c-ce94233fd3fa');
        $scope = new Scope();

        $scope->setName('student educations read');
        $scope->setCode('student.educations.read');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('26e69b08-b24f-446b-ab2f-5d303e135ef5');
        $scope = new Scope();

        $scope->setName('student educations overview');
        $scope->setCode('student.educations.overview');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        //student dutch n ts
        $id = Uuid::fromString('d77d584d-9c53-46ea-86b8-d78b77128799');
        $scope = new Scope();

        $scope->setName('student dutch n ts update');
        $scope->setCode('student.dutch.n.ts.update');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('e0b1f082-0fb9-404f-b915-ae6d7a2cacd5');
        $scope = new Scope();

        $scope->setName('student dutch n ts delete');
        $scope->setCode('student.dutch.n.ts.delete');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('b50c8059-3778-4318-b822-9a12faef52bb');
        $scope = new Scope();

        $scope->setName('student dutch n ts write');
        $scope->setCode('student.dutch.n.ts.write');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('d639da15-8bc6-4181-b57d-15fb28fe9176');
        $scope = new Scope();

        $scope->setName('student dutch n ts read');
        $scope->setCode('student.dutch.n.ts.read');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('c9a2ffb4-ca36-4db3-b7e8-61e307c1f7fc');
        $scope = new Scope();

        $scope->setName('student dutch n ts overview');
        $scope->setCode('student.dutch.n.ts.overview');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        //student dossier events
        $id = Uuid::fromString('74673a6f-272a-449c-b32f-f38d9c1fe0da');
        $scope = new Scope();

        $scope->setName('student dossier events update');
        $scope->setCode('student.dossier.events.update');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('df6ae58d-7f5b-4e2e-9e3d-bfe4588340b9');
        $scope = new Scope();

        $scope->setName('student dossier events delete');
        $scope->setCode('student.dossier.events.delete');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('323c531c-d873-4e43-9d3e-0e35cb3f90e2');
        $scope = new Scope();

        $scope->setName('student dossier events write');
        $scope->setCode('student.dossier.events.write');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('62b3f890-ca4b-434f-b83e-d0af53dfe164');
        $scope = new Scope();

        $scope->setName('student dossier events read');
        $scope->setCode('student.dossier.events.read');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('7a8f59f8-e3f2-4f6a-a41f-9893c69a68c5');
        $scope = new Scope();

        $scope->setName('student dossier events overview');
        $scope->setCode('student.dossier.events.overview');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        //student courses
        $id = Uuid::fromString('ec1d7522-4e50-4e69-89ce-ea58b4e40fdf');
        $scope = new Scope();

        $scope->setName('student courses update');
        $scope->setCode('student.courses.update');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('8bc930d7-a76d-4c88-9b2d-7ae5be8e1f1a');
        $scope = new Scope();

        $scope->setName('student courses delete');
        $scope->setCode('student.courses.delete');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('2094aff3-73ee-499c-a089-482a53dee76d');
        $scope = new Scope();

        $scope->setName('student courses write');
        $scope->setCode('student.courses.write');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('5097045f-a035-417c-b22c-777cdf53151c');
        $scope = new Scope();

        $scope->setName('student courses read');
        $scope->setCode('student.courses.read');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('ebc8995b-539a-4b70-8aec-8eac3a2a388b');
        $scope = new Scope();

        $scope->setName('student courses overview');
        $scope->setCode('student.courses.overview');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        //student contacts
        $id = Uuid::fromString('2cb0e2e0-64e9-4042-8997-fd30a47000b6');
        $scope = new Scope();

        $scope->setName('student contacts update');
        $scope->setCode('student.contacts.update');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('797e8766-38f3-4981-835f-efdffc3669cc');
        $scope = new Scope();

        $scope->setName('student contacts delete');
        $scope->setCode('student.contacts.delete');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('39d62b63-3c39-4c06-9ebb-62045abf3c96');
        $scope = new Scope();

        $scope->setName('student contacts write');
        $scope->setCode('student.contacts.write');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('cd6ec009-7766-4ce3-968d-e53e1e6534a0');
        $scope = new Scope();

        $scope->setName('student contacts read');
        $scope->setCode('student.contacts.read');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('3622d395-613a-4229-88f8-97fa0d0ca1ac');
        $scope = new Scope();

        $scope->setName('student contacts overview');
        $scope->setCode('student.contacts.overview');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        //student civic integrations
        $id = Uuid::fromString('5e935d88-fea7-4a42-8ae3-795b83f86290');
        $scope = new Scope();

        $scope->setName('student civic integrations update');
        $scope->setCode('student.civic.integrations.update');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('740377fd-5ec9-4fd8-9935-5f5b3e08c6fb');
        $scope = new Scope();

        $scope->setName('student civic integrations delete');
        $scope->setCode('student.civic.integrations.delete');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('d7484931-e9d2-40a4-b00a-f2f487690b57');
        $scope = new Scope();

        $scope->setName('student civic integrations write');
        $scope->setCode('student.civic.integrations.write');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('5d4c76f9-acab-447e-a60e-9e9fffd73ec9');
        $scope = new Scope();

        $scope->setName('student civic integrations read');
        $scope->setCode('student.civic.integrations.read');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('e49408cd-7700-41e7-afeb-2d566c464655');
        $scope = new Scope();

        $scope->setName('student civic integrations overview');
        $scope->setCode('student.civic.integrations.overview');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        //student backgrounds
        $id = Uuid::fromString('870f5123-6f23-4333-9dba-9396eb658611');
        $scope = new Scope();

        $scope->setName('student backgrounds update');
        $scope->setCode('student.backgrounds.update');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('4c143e7f-1a40-4276-9bf3-f3abbb926eed');
        $scope = new Scope();

        $scope->setName('student backgrounds delete');
        $scope->setCode('student.backgrounds.delete');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('3bfbf5d8-7d70-4c36-991c-ecafa3bc7134');
        $scope = new Scope();

        $scope->setName('student backgrounds write');
        $scope->setCode('student.backgrounds.write');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('2f32e245-45fe-4113-b80f-9055b91a8ee9');
        $scope = new Scope();

        $scope->setName('student backgrounds read');
        $scope->setCode('student.backgrounds.read');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('b8cf0334-7927-4bb6-be78-7e1fdeac10ef');
        $scope = new Scope();

        $scope->setName('student backgrounds overview');
        $scope->setCode('student.backgrounds.overview');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        //student availabilities
        $id = Uuid::fromString('d0d57712-8048-4677-8617-aa364813f766');
        $scope = new Scope();

        $scope->setName('student availabilities update');
        $scope->setCode('student.availabilities.update');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('152dd7b8-2bc2-4eac-99f3-bac0464fa786');
        $scope = new Scope();

        $scope->setName('student availabilities delete');
        $scope->setCode('student.availabilities.delete');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('d5b687bd-14e1-4c17-b914-8982396d0a91');
        $scope = new Scope();

        $scope->setName('student availabilities write');
        $scope->setCode('student.availabilities.write');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('7bb9ef4c-cb74-42cc-8fe3-3ca71cd398bb');
        $scope = new Scope();

        $scope->setName('student availabilities read');
        $scope->setCode('student.availabilities.read');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('d4a90e43-33d9-4faf-8262-97dfd69984fa');
        $scope = new Scope();

        $scope->setName('student availabilities overview');
        $scope->setCode('student.availabilities.overview');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        //students
        $id = Uuid::fromString('54abdcea-c1d1-4c84-88ea-b7a8e6fdc4c3');
        $scope = new Scope();

        $scope->setName('students update');
        $scope->setCode('students.update');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('780f3adf-d72f-4054-8dcb-5b9f228009e0');
        $scope = new Scope();

        $scope->setName('students delete');
        $scope->setCode('students.delete');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('b80bfa8e-5d7d-4056-8962-019dcc748fd0');
        $scope = new Scope();

        $scope->setName('students write');
        $scope->setCode('students.write');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('71d43bd2-374b-445f-97a7-d4e7339b374b');
        $scope = new Scope();

        $scope->setName('students read');
        $scope->setCode('students.read');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('5b9128b7-d098-4065-a3e7-c6fa8f8263d6');
        $scope = new Scope();

        $scope->setName('students overview');
        $scope->setCode('students.overview');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        //reports
        $id = Uuid::fromString('65d601ab-29fe-4217-90d9-b5acbb71c5d7');
        $scope = new Scope();

        $scope->setName('reports update');
        $scope->setCode('reports.update');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('be36ebc4-a29c-47af-93fc-3642a8b09e2e');
        $scope = new Scope();

        $scope->setName('reports delete');
        $scope->setCode('reports.delete');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('9c4bb1d0-31af-4f3e-af7c-38bc08f26957');
        $scope = new Scope();

        $scope->setName('reports write');
        $scope->setCode('reports.write');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('4aabeb31-ce68-4ca8-95e3-a507c27d7510');
        $scope = new Scope();

        $scope->setName('reports read');
        $scope->setCode('reports.read');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('ef9c6022-f372-4d35-be9a-1a9bb0704dbd');
        $scope = new Scope();

        $scope->setName('reports overview');
        $scope->setCode('reports.overview');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        //registrations
        $id = Uuid::fromString('f195f1a3-f14f-4aef-8d27-41f753c0e576');
        $scope = new Scope();

        $scope->setName('registrations update');
        $scope->setCode('registrations.update');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('0021bb4e-9ac7-46e2-8bdd-7e5de124adc2');
        $scope = new Scope();

        $scope->setName('registrations delete');
        $scope->setCode('registrations.delete');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('80ea2b5b-6948-47f9-a9ed-751933226a3f');
        $scope = new Scope();

        $scope->setName('registrations write');
        $scope->setCode('registrations.write');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('67d60831-d7b6-435d-9326-ccd26920f907');
        $scope = new Scope();

        $scope->setName('registrations read');
        $scope->setCode('registrations.read');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('fa1abf44-3956-45ed-b435-88af7b8f22c0');
        $scope = new Scope();

        $scope->setName('registrations overview');
        $scope->setCode('registrations.overview');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        //register student registrars
        $id = Uuid::fromString('1adb73c4-cef0-42f1-9c7c-b8b33a0521cf');
        $scope = new Scope();

        $scope->setName('register student registrars update');
        $scope->setCode('register.student.registrars.update');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('70593c31-1d8e-41b1-b62a-31760555f6e7');
        $scope = new Scope();

        $scope->setName('register student registrars delete');
        $scope->setCode('register.student.registrars.delete');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('5e7928e4-4382-4eae-b6bd-f30cc5a2c99a');
        $scope = new Scope();

        $scope->setName('register student registrars write');
        $scope->setCode('register.student.registrars.write');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('4dba2778-33c9-47f1-961a-e35d2116a638');
        $scope = new Scope();

        $scope->setName('register student registrars read');
        $scope->setCode('register.student.registrars.read');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('3fc42f9b-a2a6-4ce3-9a9b-d5a0e65499c3');
        $scope = new Scope();

        $scope->setName('register student registrars overview');
        $scope->setCode('register.student.registrars.overview');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        //register students
        $id = Uuid::fromString('630848f8-fe64-4ef8-a6d6-6cfaa3e21c68');
        $scope = new Scope();

        $scope->setName('register students update');
        $scope->setCode('register.students.update');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('9fb2097c-6335-447c-8e3b-7d5e1cff231d');
        $scope = new Scope();

        $scope->setName('register students delete');
        $scope->setCode('register.students.delete');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('136b81b7-7707-4c0f-9ced-d5c12f16258e');
        $scope = new Scope();

        $scope->setName('register students write');
        $scope->setCode('register.students.write');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('7320d8dc-cafa-489f-9291-580cc69ba6a2');
        $scope = new Scope();

        $scope->setName('register students read');
        $scope->setCode('register.students.read');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('ad75a524-d830-431c-ba2f-cd6af869e857');
        $scope = new Scope();

        $scope->setName('register students overview');
        $scope->setCode('register.students.overview');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        //providers
        $id = Uuid::fromString('f498a0f8-5ddf-4447-a4ad-563f639d37e2');
        $scope = new Scope();

        $scope->setName('providers update');
        $scope->setCode('providers.update');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('f5455f18-1a12-4802-bb2e-cf2515b67244');
        $scope = new Scope();

        $scope->setName('providers delete');
        $scope->setCode('providers.delete');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('b4989c99-12af-47c1-bbcb-3daf3067bb17');
        $scope = new Scope();

        $scope->setName('providers write');
        $scope->setCode('providers.write');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('bf3d642e-1f47-490b-80c9-154816b86fa7');
        $scope = new Scope();

        $scope->setName('providers read');
        $scope->setCode('providers.read');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('1c8283a1-931d-4149-a75e-4e1cac4520f6');
        $scope = new Scope();

        $scope->setName('providers overview');
        $scope->setCode('providers.overview');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        //participations
        $id = Uuid::fromString('c73c9c3b-d570-463b-8d57-929aad476084');
        $scope = new Scope();

        $scope->setName('participations update');
        $scope->setCode('participations.update');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('c6b88c29-d49e-42fa-b933-ba1099057f59');
        $scope = new Scope();

        $scope->setName('participations delete');
        $scope->setCode('participations.delete');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('e7bea05b-4b62-40a1-8f92-5fc92358b656');
        $scope = new Scope();

        $scope->setName('participations write');
        $scope->setCode('participations.write');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('d9960cd1-3089-4898-8bc7-d24b42c5ec47');
        $scope = new Scope();

        $scope->setName('participations read');
        $scope->setCode('participations.read');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('05f16c4d-d199-48e4-ab04-dd5d0cf3bcbe');
        $scope = new Scope();

        $scope->setName('participations overview');
        $scope->setCode('participations.overview');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        //learning needs
        $id = Uuid::fromString('9a011e50-5ed6-4715-aeda-5787197cb2f6');
        $scope = new Scope();

        $scope->setName('learning needs update');
        $scope->setCode('learning.needs.update');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('19b65892-9cf4-43c4-ad45-093e2840789f');
        $scope = new Scope();

        $scope->setName('learning needs delete');
        $scope->setCode('learning.needs.delete');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('88df2bf7-3400-49e5-99fd-6cae0ebc846c');
        $scope = new Scope();

        $scope->setName('learning needs write');
        $scope->setCode('learning.needs.write');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('faecbe2e-5c3c-47fe-a471-115cbdccaada');
        $scope = new Scope();

        $scope->setName('learning needs read');
        $scope->setCode('learning.needs.read');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('07c8ef08-b10c-4fef-97f4-eb7b283e1791');
        $scope = new Scope();

        $scope->setName('learning needs overview');
        $scope->setCode('learning.needs.overview');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        //language houses
        $id = Uuid::fromString('9281cdb3-42e7-4bb0-bfb9-1b5612b2cb7a');
        $scope = new Scope();

        $scope->setName('language houses update');
        $scope->setCode('language.houses.update');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('4ca3e521-3439-4e87-9f50-e79094930b56');
        $scope = new Scope();

        $scope->setName('language houses delete');
        $scope->setCode('language.houses.delete');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('0ab2bb35-afbd-477c-a8a5-94105b6baa49');
        $scope = new Scope();

        $scope->setName('language houses write');
        $scope->setCode('language.houses.write');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('9c22c073-ef98-4552-8ac0-33e341e46108');
        $scope = new Scope();

        $scope->setName('language houses read');
        $scope->setCode('language.houses.read');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('269a8cd6-9a35-41c4-a581-7308eb4943a0');
        $scope = new Scope();

        $scope->setName('language houses overview');
        $scope->setCode('language.houses.overview');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        //groups
        $id = Uuid::fromString('a396727b-11a5-4d65-978c-da242ff6e545');
        $scope = new Scope();

        $scope->setName('groups update');
        $scope->setCode('groups.update');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('18ebdcc0-9155-45f1-85af-88bb6825abce');
        $scope = new Scope();

        $scope->setName('groups delete');
        $scope->setCode('groups.delete');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('3708c114-4f47-4399-8ba3-b0dd1cb180f7');
        $scope = new Scope();

        $scope->setName('groups write');
        $scope->setCode('groups.write');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('838d7a12-9706-4b8c-96c0-a03ce5365895');
        $scope = new Scope();

        $scope->setName('groups read');
        $scope->setCode('groups.read');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('dd478453-6d07-49cd-806a-c6d7341ca3bb');
        $scope = new Scope();

        $scope->setName('groups overview');
        $scope->setCode('groups.overview');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        //employees
        $id = Uuid::fromString('a3e3f39e-be17-420a-b61a-7d7ca0dff735');
        $scope = new Scope();

        $scope->setName('employees update');
        $scope->setCode('employees.update');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('73e0176e-173f-4a73-bd18-6c470074754b');
        $scope = new Scope();

        $scope->setName('employees delete');
        $scope->setCode('employees.delete');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('cee9018c-e2be-4d4d-8b56-be067cff48a9');
        $scope = new Scope();

        $scope->setName('employees write');
        $scope->setCode('employees.write');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('1852196b-30d1-4575-a400-1789b8fb1f8d');
        $scope = new Scope();

        $scope->setName('employees read');
        $scope->setCode('employees.read');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('865837eb-ee40-4b8e-b140-f76e08a1b501');
        $scope = new Scope();

        $scope->setName('employees overview');
        $scope->setCode('employees.overview');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        //documents
        $id = Uuid::fromString('db5199fd-cc0e-4598-ae92-02a5750e5598');
        $scope = new Scope();

        $scope->setName('documents update');
        $scope->setCode('documents.update');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('d1fd1b8c-2de1-41a4-9ab8-bf7d8c06fb1b');
        $scope = new Scope();

        $scope->setName('documents delete');
        $scope->setCode('documents.delete');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('219e78f8-6688-4d80-a557-1bc0cd50c020');
        $scope = new Scope();

        $scope->setName('documents write');
        $scope->setCode('documents.write');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('b11510a3-96e8-4590-b44b-c027961bb3e8');
        $scope = new Scope();

        $scope->setName('documents read');
        $scope->setCode('documents.read');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('19c9a147-52c4-4c02-a3b1-2059421c0467');
        $scope = new Scope();

        $scope->setName('documents overview');
        $scope->setCode('documents.overview');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        //current education yes
        $id = Uuid::fromString('abf8b4a2-a242-452d-8a1e-f188c4e26cf7');
        $scope = new Scope();

        $scope->setName('current education yes update');
        $scope->setCode('current.education.yes.update');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('8fcf2a97-67c3-4d4b-adcb-ec2a234accb9');
        $scope = new Scope();

        $scope->setName('current education yes delete');
        $scope->setCode('current.education.yes.delete');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('f396a915-f59e-45e3-824d-a1f1a9c023a7');
        $scope = new Scope();

        $scope->setName('current education yes write');
        $scope->setCode('current.education.yes.write');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('07492b1b-ac87-47de-a3d7-24afb3ea8576');
        $scope = new Scope();

        $scope->setName('current education yes read');
        $scope->setCode('current.education.yes.read');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('87683047-5127-46a7-af9c-b4dbefcd0789');
        $scope = new Scope();

        $scope->setName('current education yes overview');
        $scope->setCode('current.education.yes.overview');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        //current education no but did follows
        $id = Uuid::fromString('0bdb8e30-f3db-4b4b-9913-3afdb575180d');
        $scope = new Scope();

        $scope->setName('current education no but did follows update');
        $scope->setCode('current.education.no.but.did.follows.update');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('c6cd0466-826f-48b2-83dd-41168480a136');
        $scope = new Scope();

        $scope->setName('current education no but did follows delete');
        $scope->setCode('current.education.no.but.did.follows.delete');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('7ad06c53-ef46-46dd-aab2-8c790a973f3b');
        $scope = new Scope();

        $scope->setName('current education no but did follows write');
        $scope->setCode('current.education.no.but.did.follows.write');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('4ec4a3d5-783f-4d0e-9aec-920c36dffa96');
        $scope = new Scope();

        $scope->setName('current education no but did follows read');
        $scope->setCode('current.education.no.but.did.follows.read');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('05109138-d1b8-4875-9a46-370a1a0aeb76');
        $scope = new Scope();

        $scope->setName('current education no but did follows overview');
        $scope->setCode('current.education.no.but.did.follows.overview');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        //availability days
        $id = Uuid::fromString('e576560b-218c-4a1d-8108-cca319cc8d87');
        $scope = new Scope();

        $scope->setName('availability days update');
        $scope->setCode('availability.days.update');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('e1ec0359-a866-41d4-a0b6-e37d9b726258');
        $scope = new Scope();

        $scope->setName('availability days delete');
        $scope->setCode('availability.days.delete');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('1c69e768-503f-4489-b7dd-1feb0930e5fc');
        $scope = new Scope();

        $scope->setName('availability days write');
        $scope->setCode('availability.days.write');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('62de4f91-5e51-4712-add1-3476b11403e6');
        $scope = new Scope();

        $scope->setName('availability days read');
        $scope->setCode('availability.days.read');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('6a103c6f-dc9c-4acb-abfd-eb98794bfa36');
        $scope = new Scope();

        $scope->setName('availability days overview');
        $scope->setCode('availability.days.overview');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        //availabilities
        $id = Uuid::fromString('da012db1-da83-4b1f-aef7-954f35d0e07c');
        $scope = new Scope();

        $scope->setName('availabilities update');
        $scope->setCode('availabilities.update');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('27f59974-75c2-40d1-bf82-c568d7010a38');
        $scope = new Scope();

        $scope->setName('availabilities delete');
        $scope->setCode('availabilities.delete');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('0315e4e8-141b-4917-892d-2ca9802a4f8d');
        $scope = new Scope();

        $scope->setName('availabilities write');
        $scope->setCode('availabilities.write');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('2c8b7f14-4468-4705-b8ea-e261a780bf3c');
        $scope = new Scope();

        $scope->setName('availabilities read');
        $scope->setCode('availabilities.read');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('733f218d-b541-41e3-973d-8bdf2260b2a4');
        $scope = new Scope();

        $scope->setName('availabilities overview');
        $scope->setCode('availabilities.overview');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        //addresses
        $id = Uuid::fromString('89d7aefe-0889-4c74-b6c4-c66a90e67030');
        $scope = new Scope();

        $scope->setName('addresses update');
        $scope->setCode('addresses.update');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('2e1f5302-2c4a-4faa-9fe3-f4ea2cf0a333');
        $scope = new Scope();

        $scope->setName('addresses delete');
        $scope->setCode('addresses.delete');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('f8d95c3a-98a4-4fbf-8ac9-a9feba2929ed');
        $scope = new Scope();

        $scope->setName('addresses write');
        $scope->setCode('addresses.write');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('07c3b033-b0e2-47d8-aad7-92d387045aac');
        $scope = new Scope();

        $scope->setName('addresses read');
        $scope->setCode('addresses.read');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('81dedbd0-252f-48a5-8e77-601d30eb25f9');
        $scope = new Scope();

        $scope->setName('addresses overview');
        $scope->setCode('addresses.overview');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();
    }
}
