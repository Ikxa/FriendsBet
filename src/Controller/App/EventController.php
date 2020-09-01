<?php

namespace App\Controller\App;

use App\Entity\App\Match;
use App\Api\Football;
use App\Entity\App\Sport;
use App\Form\App\MatchType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/**
 * Class EventController
 *
 * @package App\Controller\App
 */
class EventController extends AbstractController
{
    /**
     * @var Football
     */
    private $api;

    /**
     * EventController constructor.
     *
     * @param Football $footballApi
     */
    public function __construct(Football $footballApi)
    {
        $this->api = $footballApi;
    }

    /**
     * @Route("/events", name="event.index")
     *
     * @param PaginatorInterface $paginator
     * @param Request            $request
     *
     * @return Response
     */
    public function index(): Response
    {
        $matchsUrl = 'https://api-football-v1.p.rapidapi.com/v2/fixtures/league/2664/next/50?timezone=Europe/Paris';
        $matchs = $this->api->sendRequest('GET', $matchsUrl);

        /*foreach ($matchs["api"]["fixtures"] as $match) {
            $oddsUrl = 'https://api-football-v1.p.rapidapi.com/v2/predictions/' . $match["fixture_id"];
            $odds = $this->api->sendRequest('GET', $oddsUrl);
            $match["odds"][] = $odds;
        }

        dump($matchs);
        die;*/

        return $this->render(
            'app/event/index.html.twig',
            [
                'matchs' => $matchs,
            ]
        );
    }
    
    /**
     * @Route("/event/add", name="event.add")
     * @param EntityManagerInterface $em
     *
     * @return Response
     */
    public function add(EntityManagerInterface $em, Request $request): Response
    {
        $match = new Match();
        $form = $this->createForm(MatchType::class, $match);
        $form->handleRequest($request);
        $form = $this->createForm(MatchType::class);

        if ($form->isSubmitted() && $form->isValid()) {
            $match->setIsCustom(TRUE);
            $match->setPlayedAt(new DateTime());
            $match->setIsOver(FALSE);
            $match->setMatchId(mt_rand());

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

    /**
     * @Route("/event/bet/{id}", name="event.bet")
     *
     * @param int $id
     * @param EntityManagerInterface $entityManager
     *
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     *
     * @return Response
     */
    public function bet(int $id, EntityManagerInterface $entityManager): Response
    {
        $matchSelectedUrl = 'https://api-football-v1.p.rapidapi.com/v2/fixtures/id/'.$id.'?timezone=Europe/Paris';
        $match = $this->api->sendRequest('GET', $matchSelectedUrl);

        $matchSaved = new Match();
        $matchSaved->setSport($this->getDoctrine()->getRepository(Sport::class)->findOneBy(['id' => 1]));
        $matchSaved->setFirstTeam($match["api"]["fixtures"][0]["homeTeam"]["team_name"]);
        $matchSaved->setSecondTeam($match["api"]["fixtures"][0]["awayTeam"]["team_name"]);
        $matchSaved->setScoreFirstTeam($match["api"]["fixtures"][0]["goalsHomeTeam"] ?? 0);
        $matchSaved->setScoreSecondTeam($match["api"]["fixtures"][0]["goalsAwayTeam"] ?? 0);
        $playedAt = date('d/m/Y H:i:s', $match["api"]["fixtures"][0]["event_timestamp"]);
        $matchSaved->setPlayedAt(new \DateTime($playedAt));
        $matchSaved->setIsOver(false);
        $matchSaved->setStatus($match["api"]["fixtures"][0]["status"]);
        $matchSaved->setWinner($match["api"]["fixtures"][0]["statusShort"]);
        $matchSaved->setMatchId($match["api"]["fixtures"][0]["fixture_id"]);
        $matchSaved->setIsCustom(false);

        $entityManager->persist($matchSaved);
        $entityManager->flush();

        return $this->render(
            'app/event/bet.html.twig',
            [
                'match' => $match["api"]["fixtures"],
            ]
        );
    }
}
