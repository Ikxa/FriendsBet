<?php

namespace App\DataFixtures;

use App\Entity\App\Team;
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
        $team1->setLogo("public/images/clubs-logo/PSG.png");
        $team1->setLeague(1);
        $team1->setIsActive(true);
        $team2 = new Team();
        $team2->setName("Auxerre");
        $team2->setLogo("public/images/clubs-logo/AJ Auxerre.png");
        $team2->setLeague(2);
        $team2->setIsActive(true);
        $team3 = new Team();
        $team3->setName("Angers");
        $team3->setLogo("public/images/clubs-logo/Angers.png");
        $team3->setLeague(1);
        $team3->setIsActive(true);
        $team4 = new Team();
        $team4->setName("Monaco");
        $team4->setLogo("public/images/clubs-logo/AS Monaco.png");
        $team4->setLeague(1);
        $team4->setIsActive(true);
        $team5 = new Team();
        $team5->setName("ASSE");
        $team5->setLogo("public/images/clubs-logo/ASSE.png");
        $team5->setLeague(1);
        $team5->setIsActive(true);
        $team6 = new Team();
        $team6->setName("Bordeaux");
        $team6->setLogo("public/images/clubs-logo/Bordeaux.png");
        $team6->setLeague(1);
        $team6->setIsActive(true);
        $team7 = new Team();
        $team7->setName("Brest");
        $team7->setLogo("public/images/clubs-logo/Brest.png");
        $team7->setLeague(2);
        $team7->setIsActive(true);
        $team8 = new Team();
        $team8->setName("Dijon");
        $team8->setLogo("public/images/clubs-logo/Dijon.png");
        $team8->setLeague(1);
        $team8->setIsActive(true);
        $team9 = new Team();
        $team9->setName("Lens");
        $team9->setLogo("public/images/clubs-logo/Lens.png");
        $team9->setLeague(1);
        $team9->setIsActive(true);
        $team10 = new Team();
        $team10->setName("Lorient");
        $team10->setLogo("public/images/clubs-logo/Lorient.png");
        $team10->setLeague(1);
        $team10->setIsActive(true);
        $team11 = new Team();
        $team11->setName("LOSC");
        $team11->setLogo("public/images/clubs-logo/LOSC.png");
        $team11->setLeague(1);
        $team11->setIsActive(true);
        $team12 = new Team();
        $team12->setName("Lyon");
        $team12->setLogo("public/images/clubs-logo/Lyon.png");
        $team12->setLeague(1);
        $team12->setIsActive(true);
        $team13 = new Team();
        $team13->setName("Marseille");
        $team13->setLogo("public/images/clubs-logo/Marseille.png");
        $team13->setLeague(1);
        $team13->setIsActive(true);
        $team14 = new Team();
        $team14->setName("Metz");
        $team14->setLogo("public/images/clubs-logo/Metz.png");
        $team14->setLeague(1);
        $team14->setIsActive(true);
        $team15 = new Team();
        $team15->setName("Montpellier");
        $team15->setLogo("public/images/clubs-logo/Montpellier.png");
        $team15->setLeague(1);
        $team15->setIsActive(true);
        $team16 = new Team();
        $team16->setName("Nantes");
        $team16->setLogo("public/images/clubs-logo/Nantes.png");
        $team16->setLeague(1);
        $team16->setIsActive(true);
        $team17 = new Team();
        $team17->setName("Nice");
        $team17->setLogo("public/images/clubs-logo/Nice.png");
        $team17->setLeague(1);
        $team17->setIsActive(true);
        $team18 = new Team();
        $team18->setName("Nîmes");
        $team18->setLogo("public/images/clubs-logo/Nîmes.png");
        $team18->setLeague(1);
        $team18->setIsActive(true);
        $team19 = new Team();
        $team19->setName("Reims");
        $team19->setLogo("public/images/clubs-logo/Reims.png");
        $team19->setLeague(1);
        $team19->setIsActive(true);
        $team20 = new Team();
        $team20->setName("Rennes");
        $team20->setLogo("public/images/clubs-logo/Rennes.png");
        $team20->setLeague(1);
        $team20->setIsActive(true);
        $team21 = new Team();
        $team21->setName("Strasbourg");
        $team21->setLogo("public/images/clubs-logo/Strasbourg.png");
        $team21->setLeague(1);
        $team22 = new Team();
        $team22->setIsActive(true);
        $team22->setName("Toulouse");
        $team22->setLogo("public/images/clubs-logo/Toulouse.png");
        $team22->setLeague(1);
        $team22->setIsActive(true);

        $manager->flush();
    }
}
