<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use App\Entity\User;
use App\Entity\Group;
use App\Entity\Scope;

class AppFixtures extends Fixture
{
    private $params;
    private $encoder;

    public function __construct(ParameterBagInterface $params, UserPasswordEncoderInterface $encoder)
    {
        $this->params = $params;
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        // Lets make sure we only run these fixtures on larping enviroment
        if (strpos($this->params->get('app_domain'), "conduction.nl") == false) {
           // return false;
        }

        $componentList = [
            "vrc" => ["requests", "submitters", "roles"],
            "vtc" => ["requestTypes", "properties"],
            "ptc" => ["processTypes", "stages"],
            "wtc" => ["images", "menus", "menuItems", "organizations", "slugs", "styles", "templates", "templateGroups"],
            "que" => ["tasks"],
            "dps" => ["apiDocs"],
            "memo" => ["memos"],
            "orc" => ["orders", "orderItems", "organizations", "taxes"],
            "arc" => ["calendars", "alarms", "events", "freeBussies", "journals", "resources", "schedules", "todos"],
            "stuf" => ["stufInterfaces"],
            "tc" => ["tasks"],
            "pfc" => ["activities", "evaluations", "formalRecognitions" ,"products", "reflections", "results"],
            "mrc" => ["applications", "competences", "contracts", "employees", "goals", "interests", "jobFunctions", "jobPostings", "skills"],
            "bc" => ["invoices", "invoiceItems", "organizations", "payments", "services", "taxes"],
            "chrc" => ["challenges", "pitches"],
            "cmc" => ["contactMoments"],
            "evc" => ["clusters", "components", "domains", "environments", "installations"],
            "irc" => ["assents"],
            "as" => ["addresses"],
            "pdc" => ["catalogues" , "customerTypes", "groups", "offers", "products", "propertyValues", "suppliers", "taxes"],
            "lc" => ["accommodations", "places"],
            "cc" => ["addresses", "contactLists", "emails", "organizations", "persons", "telephones"],
            "bs" => ["messages", "services"],
            "ltc" => ["rsin", "tabel32", "tabel33", "tabel34", "tabel36", "tabel37", "tabel38", "tabel39", "tabel41", "tabel48", "tabel49", "tabel55", "tabel56"],
            "brp" => [],
            "rc" => ["aspects", "likes", "ratings", "reviews"],
            "cgrc" => ["components", "componentFiles"]
        ];

        $scopes = ['create','read','update','delete'];

        foreach($componentList as $code=> $resources){
            // N tot 2 @todo better formuleren
            foreach($resources as $resource){
                // N tot 3 noooooooo
                foreach($scopes as $scope){

                    $scope = new Scope();
                    $scope->setName($scope.' '.$resources);
                    $scope->setCode($code.'.'.$resource.'.'.$scope);
                    $manager->persist($scope);
                }

            }

        }


        $manager->flush();
    }
}
