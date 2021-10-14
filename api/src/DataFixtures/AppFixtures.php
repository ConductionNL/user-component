<?php

namespace App\DataFixtures;

use App\Entity\Scope;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
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
        // The fixtures will always be loaded
        $componentList = [
            'vrc'  => ['requests', 'submitters', 'roles', 'labels'],
            'vtc'  => ['requestTypes', 'properties'],
            'ptc'  => ['processTypes', 'stages', 'sections'],
            'wtc'  => ['images', 'menus', 'menuItems', 'organizations', 'slugs', 'styles', 'templates', 'templateGroups'],
            'qc'   => ['tasks'],
            'dps'  => ['apiDocs'],
            'memo' => ['memos'],
            'orc'  => ['orders', 'orderItems', 'organizations', 'taxes'],
            'arc'  => ['calendars', 'alarms', 'events', 'freeBussies', 'journals', 'resources', 'schedules', 'todos'],
            'stuf' => ['stufInterfaces'],
            'tc'   => ['tasks'],
            'pfc'  => ['activities', 'evaluations', 'formalRecognitions', 'products', 'reflections', 'results'],
            'mrc'  => ['applications', 'competences', 'contracts', 'employees', 'goals', 'interests', 'jobFunctions', 'jobPostings', 'skills'],
            'bc'   => ['invoices', 'invoiceItems', 'organizations', 'payments', 'services', 'taxes'],
            'chrc' => ['challenges', 'pitches'],
            'cmc'  => ['contactMoments'],
            'evc'  => ['clusters', 'components', 'domains', 'environments', 'installations'],
            'irc'  => ['assents'],
            'as'   => ['addresses'],
            'pdc'  => ['catalogues', 'customerTypes', 'groups', 'offers', 'products', 'propertyValues', 'suppliers', 'taxes'],
            'lc'   => ['accommodations', 'places', 'properties', 'placeProperties', 'accommodationProperties'],
            'cc'   => ['addresses', 'contactLists', 'emails', 'organizations', 'persons', 'telephones'],
            'bs'   => ['messages', 'services'],
            'ltc'  => ['rsin', 'tabel32', 'tabel33', 'tabel34', 'tabel36', 'tabel37', 'tabel38', 'tabel39', 'tabel41', 'tabel48', 'tabel49', 'tabel55', 'tabel56'],
            'brp'  => [],
            'rc'   => ['aspects', 'likes', 'ratings', 'reviews'],
            'cgrc' => ['components', 'componentFiles', 'apis', 'organisations'],
            'uc'   => ['applications', 'groups', 'providers', 'scopes', 'tokens', 'users'],
            'brc'  => ['contacts', 'users'],
            'wrc'  => ['applications', 'configurations', 'images', 'menus', 'menuItems', 'organizations', 'slugs', 'styles', 'templates', 'templateGroups'],
            'ec'   => ['exports'],
        ];

        $scopes = ['create', 'read', 'update', 'delete'];

        foreach ($componentList as $code=> $resources) {
            // N tot 2 @todo better formuleren
            foreach ($resources as $resource) {
                // N tot 3 noooooooo
                foreach ($scopes as $scopeString) {
                    $scope = new Scope();
                    $scope->setName($scopeString.' '.$resource);
                    $scope->setCode($code.'.'.$resource.'.'.$scopeString);
                    $manager->persist($scope);
                }
            }
        }

        $manager->flush();
    }
}
