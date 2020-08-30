<?php


namespace App\Command;


use App\Api\Football;
use App\Entity\App\Match;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class CronUpdateMatchsCommand extends Command
{
    /** @var Football */
    private $api;
    
    /** @var EntityManagerInterface */
    private $entityManager;
    
    /** @var string */
    protected static $defaultName = 'app:update-matchs';
    
    /**
     * CronUpdateMatchs constructor.
     *
     * @param Football               $footballApi
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(Football $footballApi, EntityManagerInterface $entityManager)
    {
        parent::__construct();
        
        $this->api = $footballApi;
        $this->entityManager = $entityManager;
    }
    
    protected function configure(): void
    {
        // On set la description de la commande
        $this->setDescription('Permet de mettre à jour les matchs');
        // On set l'aide
        $this->setHelp('php bin/console update:matchs');
    }
    
    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     *
     * @return int
     */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $times = $this->api->getTimes();
        $uri = 'https://api.football-data.org/v2/competitions/FL1/matches/?dateFrom='.$times['startWeek'].'&'.'dateTo='.$times['endWeek'];
        $content = $this->api->sendRequest('GET', $uri);
        
        foreach ($content["matches"] as $matchApi) {
            $match = $this->entityManager
                ->getRepository(Match::class)
                ->findOneBy(['match_id' => $matchApi['id']]);
            
            if (!empty($match) && ($match->getMatchId() == $matchApi['id'])) {
                $match->setScoreFirstTeam($matchApi['score']['fullTime']['homeTeam'] ?? 0);
                $match->setScoreSecondTeam($matchApi['score']['fullTime']['awayTeam'] ?? 0);
                $match->setStatus($matchApi['status']);
                if ($matchApi['status'] === 'FINISHED') {
                    $match->setWinner($match->getScoreFirstTeam() > $match->getScoreSecondTeam() ? $match->getFirstTeam() : $match->getSecondTeam());
                }
                
                $this->entityManager->persist($match);
                $this->entityManager->flush();
            } else {
                $output->writeln('Match non trouvé !');
            }
        }
        $output->writeln('Mise à jour effectuée !');
        
        return Command::SUCCESS;
    }
}
