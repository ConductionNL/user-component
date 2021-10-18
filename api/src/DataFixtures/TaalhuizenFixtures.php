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

        $id = Uuid::fromString('8e90f9f0-acb7-406d-9550-be614040effd');
        $bisc = new Group();
        $bisc->setName('bisc');
        $bisc->setDescription('bisc group');
        $bisc->setOrganization('https://taalhuizen-bisc.commonground.nu/api/v1/wrc/organizations/008750e5-0424-440e-aea0-443f7875fbfe');
        $manager->persist($bisc);
        $bisc->setId($id);
        $manager->persist($bisc);
        $manager->flush();
        $bisc = $manager->getRepository('App:Group')->findOneBy(['id'=> $id]);

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
        $scope->setName('users remove');
        $scope->setCode('users.remove');
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
        $scope->setName('user create');
        $scope->setCode('user.create');
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
        $scope->setName('user read');
        $scope->setCode('user.read');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('87abd1e0-d1cb-4b09-be3b-b6d75d6c7cd6');
        $scope = new Scope();
        $scope->setName('current user read');
        $scope->setCode('current.user.read');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('bb6623ac-6ea1-4f90-b5ab-b9a3e7cd00ae');
        $scope = new Scope();
        $scope->setName('password reset user request');
        $scope->setCode('password.reset.user.request');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('f32b8555-f76d-4dfc-9952-47faeec267b8');
        $scope = new Scope();
        $scope->setName('password user reset');
        $scope->setCode('password.user.reset');
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
        $scope->setName('test result update');
        $scope->setCode('test.result.update');
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
        $scope->setName('test result remove');
        $scope->setCode('test.result.remove');
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
        $scope->setName('test result create');
        $scope->setCode('test.result.create');
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

        $id = Uuid::fromString('f56f3aad-18c4-42ea-8e44-3075e5581115');
        $scope = new Scope();
        $scope->setName('test result read');
        $scope->setCode('test.result.read');
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
        $scope->setName('student update');
        $scope->setCode('student.update');
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
        $scope->setName('student remove');
        $scope->setCode('student.remove');
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
        $scope->setName('student create');
        $scope->setCode('student.create');
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

        $id = Uuid::fromString('9b921b14-9743-4339-9848-b6d08381262d');
        $scope = new Scope();
        $scope->setName('student read');
        $scope->setCode('student.read');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('c2de51c6-a30e-42e6-a170-bd5b9b29b22f');
        $scope = new Scope();
        $scope->setName('aanbieder employee mentees students read');
        $scope->setCode('aanbieder.employee.mentees.students.read');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('49e5811e-3883-48be-975e-eb354e2a065f');
        $scope = new Scope();
        $scope->setName('group students read');
        $scope->setCode('group.students.read');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('0b1e641f-22c7-4ab8-853a-8e69b301fcc0');
        $scope = new Scope();
        $scope->setName('new reffered students read');
        $scope->setCode('new.reffered.students.read');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('946278f7-b723-45b2-822e-90b40107844a');
        $scope = new Scope();
        $scope->setName('active students read');
        $scope->setCode('active.students.read');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('11ee5832-392d-4384-a7cc-cfd38f1cc15a');
        $scope = new Scope();
        $scope->setName('completed students read');
        $scope->setCode('completed.students.read');
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
        $scope->setName('registration remove');
        $scope->setCode('registration.remove');
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
        $scope->setName('registration create');
        $scope->setCode('registration.create');
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

        $id = Uuid::fromString('792de6ab-e613-45ed-adf4-3d23834a7d2e');
        $scope = new Scope();
        $scope->setName('registration read');
        $scope->setCode('registration.read');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('d219e440-d9b6-45a9-9a4f-60e7e71271dc');
        $scope = new Scope();
        $scope->setName('registration accept');
        $scope->setCode('registration.accept');
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
        $scope->setName('provider update');
        $scope->setCode('provider.update');
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
        $scope->setName('provider remove');
        $scope->setCode('provider.remove');
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
        $scope->setName('provider create');
        $scope->setCode('provider.create');
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

        $id = Uuid::fromString('ad3831b5-b47f-48cf-b2fd-77b2d0431c7f');
        $scope = new Scope();
        $scope->setName('provider read');
        $scope->setCode('provider.read');
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
        $scope->setName('participation update');
        $scope->setCode('participation.update');
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
        $scope->setName('participation remove');
        $scope->setCode('participation.remove');
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
        $scope->setName('participation create');
        $scope->setCode('participation.create');
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

        $id = Uuid::fromString('a6883023-a33a-424c-8913-9d67bafb7975');
        $scope = new Scope();
        $scope->setName('participation read');
        $scope->setCode('participation.read');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('7836b5a5-f69c-48a1-9b70-ce2b05122872');
        $scope = new Scope();
        $scope->setName('group to participation add');
        $scope->setCode('group.to.participation.add');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('15159bdc-6038-42d2-aabc-4921dc12474a');
        $scope = new Scope();
        $scope->setName('group participation update');
        $scope->setCode('group.participation.update');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('96760c0f-adeb-43f6-bd7b-ece04149d255');
        $scope = new Scope();
        $scope->setName('group from participation remove');
        $scope->setCode('group.from.participation.remove');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('bcc32632-d527-44f3-85c1-e8dc5c347816');
        $scope = new Scope();
        $scope->setName('mentored participation to employee add');
        $scope->setCode('mentored.participation.to.employee.add');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('6da08fb7-7ba1-41c1-9119-8a55646a6418');
        $scope = new Scope();
        $scope->setName('mentor to participation add');
        $scope->setCode('mentor.to.participation.add');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('ba672ccb-12e3-44ee-a0a0-1da43ccb3b62');
        $scope = new Scope();
        $scope->setName('mentor participation update');
        $scope->setCode('mentor.participation.update');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('9e6b739a-1844-4062-a824-93bb0ff4ad5d');
        $scope = new Scope();
        $scope->setName('mentor from participation remove');
        $scope->setCode('mentor.from.participation.remove');
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
        $scope->setName('learning need update');
        $scope->setCode('learning.need.update');
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
        $scope->setName('learning need remove');
        $scope->setCode('learning.need.remove');
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
        $scope->setName('learning need create');
        $scope->setCode('learning.need.create');
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

        $id = Uuid::fromString('20835e5d-77f6-4e49-b79e-f2a11d70c43b');
        $scope = new Scope();
        $scope->setName('learning need read');
        $scope->setCode('learning.need.read');
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
        $scope->setName('language house update');
        $scope->setCode('language.house.update');
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
        $scope->setName('language house remove');
        $scope->setCode('language.house.remove');
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
        $scope->setName('language house create');
        $scope->setCode('language.house.create');
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

        $id = Uuid::fromString('9895ae60-a9bc-44cc-a03f-7305f4f4b49d');
        $scope = new Scope();
        $scope->setName('language house read');
        $scope->setCode('language.house.read');
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
        $scope->setName('group update');
        $scope->setCode('group.update');
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
        $scope->setName('group remove');
        $scope->setCode('group.remove');
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
        $scope->setName('group create');
        $scope->setCode('group.create');
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

        $id = Uuid::fromString('0e9db501-b099-4ba6-a559-d5f7d8adae4a');
        $scope = new Scope();
        $scope->setName('group read');
        $scope->setCode('group.read');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('a6f5a8ef-48d1-4176-b57c-404921823108');
        $scope = new Scope();
        $scope->setName('active groups read');
        $scope->setCode('active.groups.read');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('c88a5158-3004-4578-a4b8-f74f20bf32ea');
        $scope = new Scope();
        $scope->setName('completed groups read');
        $scope->setCode('completed.groups.read');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('ed89bc1f-391b-4ead-a83e-fdfa4222245a');
        $scope = new Scope();
        $scope->setName('future groups read');
        $scope->setCode('future.groups.read');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('5ecc33e1-ee44-411b-9d5c-f54886ba1799');
        $scope = new Scope();
        $scope->setName('teachers of the group change');
        $scope->setCode('teachers.of.the.group.change');
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
        $scope->setName('employee update');
        $scope->setCode('employee.update');
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
        $scope->setName('employee remove');
        $scope->setCode('employee.remove');
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
        $scope->setName('employee create');
        $scope->setCode('employee.create');
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

        $id = Uuid::fromString('510d31b9-57c6-4f8d-8eec-9be8f892353e');
        $scope = new Scope();
        $scope->setName('employee read');
        $scope->setCode('employee.read');
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
        $scope->setName('document update');
        $scope->setCode('document.update');
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
        $scope->setName('document remove');
        $scope->setCode('document.remove');
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
        $scope->setName('document create');
        $scope->setCode('document.create');
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

        $id = Uuid::fromString('56d01028-dacd-4bbb-b5b1-d15ecc1e4761');
        $scope = new Scope();
        $scope->setName('document read');
        $scope->setCode('document.read');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('9e1d14fb-f395-4854-846f-684457f83aa9');
        $scope = new Scope();
        $scope->setName('document download');
        $scope->setCode('document.download');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('d0a2d1cc-f28f-465e-84cb-61ed95175ad8');
        $scope = new Scope();
        $scope->setName('user roles by language houses read');
        $scope->setCode('user.roles.by.language.houses.read');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('08d05e9f-3ef9-4bb4-a3bb-64383a485ed0');
        $scope = new Scope();
        $scope->setName('user roles by providers read');
        $scope->setCode('user.roles.by.providers.read');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('23aecc7b-6943-4a37-ad02-3be6b842ee6f');
        $scope = new Scope();
        $scope->setName('desired learning outcomes report download');
        $scope->setCode('desired.learning.outcomes.report.download');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('c10e5237-5f1c-4ede-a080-a41e35a2b723');
        $scope = new Scope();
        $scope->setName('participants report download');
        $scope->setCode('participants.report.download');
        $manager->persist($scope);
        $scope->setId($id);
        $manager->persist($scope);
        $manager->flush();
        $scope = $manager->getRepository('App:Scope')->findOneBy(['id'=> $id]);
        $scope->addUserGroup($admin);
        $manager->persist($scope);
        $manager->flush();

        $id = Uuid::fromString('67407c7d-487f-4da7-8514-6011ff352e7e');
        $scope = new Scope();
        $scope->setName('volunteers report download');
        $scope->setCode('volunteers.report.download');
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
