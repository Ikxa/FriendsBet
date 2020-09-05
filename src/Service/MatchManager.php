<?php


namespace App\Service;


use App\Api\Football;
use App\Entity\App\MatchToBet;
use App\Entity\App\Sport;
use Doctrine\ORM\EntityManagerInterface;

class MatchManager
{
    /**
     * @var Football
     */
    private $api;
    
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    
    /**
     * MatchManager constructor.
     *
     * @param Football               $footballApi
     * @param EntityManagerInterface $em
     */
    public function __construct(Football $footballApi, EntityManagerInterface $em)
    {
        $this->api = $footballApi;
        $this->entityManager = $em;
    }
    
    /*public function verifyWarm(array $times)
    {
        $warmRepository = $this->entityManager->getRepository(Warm::class);
        
        return $warmRepository->findOneBy(['start_date' => new \DateTime($times['startWeek']), 'end_date' => new \DateTime($times['endWeek'])]);
    }*/
    
    /*public function addMatchBetweenDates(): bool
    {
        // Récupérons les matchs
        $times = $this->api->getTimes();
        $is_warm = $this->verifyWarm($times);
        
        if (!isset($is_warm) && empty($is_warm)) {
            $uri = 'https://api.football-data.org/v2/competitions/FL1/matches/?dateFrom='.$times['startWeek'].'&'.'dateTo='.$times['endWeek'];
            $content = $this->api->sendRequest('GET', $uri);
            $warm = new Warm();
            
            // Ajoutons les matchs récupérés
            foreach ($content["matches"] as $match) {
                $matchToSave = new MatchToBet();
                $sport = $this->entityManager->getRepository(Sport::class)->findOneBy(['label' => 'Football']);
                $matchToSave->setFirstTeam($match['homeTeam']['name']);
                $matchToSave->setSecondTeam($match['awayTeam']['name']);
                $matchToSave->setIsOver(FALSE);
                $matchToSave->setPlayedAt(new \DateTime($match['utcDate']));
                $matchToSave->setScoreFirstTeam($match['score']['fullTime']['homeTeam'] ?? 0);
                $matchToSave->setScoreSecondTeam($match['score']['fullTime']['awayTeam'] ?? 0);
                $matchToSave->setMatchId($match['id']);
                $matchToSave->setSport($sport);
                $matchToSave->setStatus($match['status']);
                $matchToSave->setWinner('UNDEFINED');
                
                $this->entityManager->persist($matchToSave);
            }
            $warm->setStartDate(new \DateTime($times['startWeek']));
            $warm->setEndDate(new \DateTime($times['endWeek']));
            $warm->setIsDone(TRUE);
            $this->entityManager->persist($warm);
            $this->entityManager->flush();
            
            return TRUE;
        }
        
        return FALSE;
    }*/
}
