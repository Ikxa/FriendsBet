<?php

namespace App\DataFixtures;

use App\Entity\Team;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        
        // ctrl-D
        // clic molette
        // alt-clic

        $team1 = new Team();
        $team1->setName("PSG");
        $team1->setLogo("PSG.png");
        $team1->setLeague(1);
        $team1->setIsActive(true);
        $team2 = new Team();
        $team2->setName("Auxerre");
        $team2->setLogo("AJ Auxerre.png");
        $team2->setLeague(1);
        $team2->setIsActive(true);
        $team3 = new Team();
        $team3->setName("Angers");
        $team3->setLogo("Angers.png");
        $team3->setLeague(1);
        $team3->setIsActive(true);
        $team4 = new Team();
        $team4->setName("Monaco");
        $team4->setLogo("AS Monaco.png");
        $team4->setLeague(1);
        $team4->setIsActive(true);
        $team5 = new Team();
        $team5->setName("ASSE");
        $team5->setLogo("ASSE.png");
        $team5->setLeague(1);
        $team5->setIsActive(true);
        $team6 = new Team();
        $team6->setName("Bordeaux");
        $team6->setLogo("Bordeaux.png");
        $team6->setLeague(1);
        $team6->setIsActive(true);
        $team7 = new Team();
        $team7->setName("Brest");
        $team7->setLogo("Brest.png");
        $team7->setLeague(1);
        $team7->setIsActive(true);
        $team8 = new Team();
        $team8->setName("Dijon");
        $team8->setLogo("Dijon.png");
        $team8->setLeague(1);
        $team8->setIsActive(true);
        $team9 = new Team();
        $team9->setName("Lens");
        $team9->setLogo("Lens.png");
        $team9->setLeague(1);
        $team9->setIsActive(true);
        $team10 = new Team();
        $team10->setName("Lorient");
        $team10->setLogo("Lorient.png");
        $team10->setLeague(1);
        $team10->setIsActive(true);
        $team11 = new Team();
        $team11->setName("LOSC");
        $team11->setLogo("LOSC.png");
        $team11->setLeague(1);
        $team11->setIsActive(true);

        $manager->flush();
    }
}
