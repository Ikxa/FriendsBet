<?php

namespace App\Controller\App;

use App\Entity\App\Match;
use App\Api\Football;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{
    private $api;
    
    public function __construct(Football $footballApi)
    {
        $this->api = $footballApi;
    }
    
    /**
     * @Route("/events", name="event.index")
     */
    public function index(): Response
    {
        $matchs = $this->getDoctrine()
            ->getRepository(Match::class)
            ->findAll();
        
        return $this->render(
            'app/event/index.html.twig',
            [
                'matchs' => $matchs,
            ]
        );
    }
    
    /**
     * @Route("/event/bet/{id}", name="event.bet")
     *
     * @param int                    $id
     * @param EntityManagerInterface $entityManager
     *
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     *
     * @return Response
     */
    public function bet(int $id, EntityManagerInterface $entityManager): Response
    {
        $uri = 'https://api.football-data.org/v2/matches/' . $id;
        $content = $this->api->sendRequest('GET', $uri);
        $existingMatch = $this->getDoctrine()
            ->getRepository(Match::class)
            ->findOneBy(['matchId' => $content['match']['id']]);
        
        /*if (!isset($existingMatch) || empty($existingMatch))
        {
            $match = new Match();
            $sport = $this->getDoctrine()->getRepository(Sport::class)->findOneBy(['label' => 'Football']);
            $match->setTeamOne($content['match']['homeTeam']['name']);
            $match->setTeamTwo($content['match']['awayTeam']['name']);
            $match->setIsOver(false);
            $match->setPlayedAt(new \DateTime($content['match']['utcDate']));
            $match->setScoreHometeam($content['match']['score']['fullTime']['homeTeam'] ?? 0);
            $match->setScoreAwayteam($content['match']['score']['fullTime']['awayTeam'] ?? 0);
            $match->setMatchId($content['match']['id']);
            $match->setSport($sport);
    
            $entityManager->persist($match);
            $entityManager->flush();
        }
    
        $teams = array_merge($content['match']['homeTeam'], $content['match']['awayTeam']);*/
        $bet = new Bet();
        $form = $this->createForm(BetType::class, $bet);
        
        if ($form->isSubmitted() && $form->isValid())
        {
            $bet->setBetAt(new \DateTime());
            $bet->setRencontre($existingMatch ?? $match);
            $bet->addUser($this->getUser());
        }
        
        return $this->render('app/event/bet.html.twig', [
            'form' => $form->createView(),
            'match' => $existingMatch ?? $match,
        ]);
    }
    
    /**
     * @Route("/event/add", name="event.add")
     * @param EntityManagerInterface $em
     */
    public function add(EntityManagerInterface $em): Response
    {
        $match = new Match();
        $form = $this->createForm(MatchType::class);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($match);
            $em->flush();
            
            return $this->redirectToRoute('event.index');
        }
        
        return $this->render(
            'app/event/add.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}
