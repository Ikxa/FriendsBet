<?php

namespace App\Controller\App;

use App\Entity\App\Bet;
use App\Api\Football;
use App\Entity\App\MatchToBet;
use App\Entity\App\Sport;
use App\Form\App\BetType;
use App\Form\App\MatchToBetType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
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
     * @return Response
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     *
     * @throws ClientExceptionInterface
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
        $match = new MatchToBet();
        $form = $this->createForm(MatchToBetType::class, $match);
        $form->handleRequest($request);
        $form = $this->createForm(MatchToBetType::class);

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
     * @param Request $request
     * @return Response
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function bet(int $id, EntityManagerInterface $entityManager, Request $request): Response
    {
        $matchSelectedUrl = 'https://api-football-v1.p.rapidapi.com/v2/fixtures/id/' . $id . '?timezone=Europe/Paris';
        $match = $this->api->sendRequest('GET', $matchSelectedUrl);
        // Bet form
        $bet = new Bet();
        $form = $this->createForm(BetType::class, $bet);
        $form->handleRequest($request);
        $existingMatch = $this->getDoctrine()
            ->getRepository(MatchToBet::class)
            ->findOneBy(['match_id' => $match["api"]["fixtures"][0]["fixture_id"]])
        ;

        if (!isset($existingMatch) && empty($existingMatch)) {
            $matchSaved = new MatchToBet();
            $matchSaved->setSport($this->getDoctrine()->getRepository(Sport::class)->findOneBy(['id' => 1]));
            $matchSaved->setFirstTeam($match["api"]["fixtures"][0]["homeTeam"]["team_name"]);
            $matchSaved->setSecondTeam($match["api"]["fixtures"][0]["awayTeam"]["team_name"]);
            $matchSaved->setScoreFirstTeam($match["api"]["fixtures"][0]["goalsHomeTeam"] ?? 0);
            $matchSaved->setScoreSecondTeam($match["api"]["fixtures"][0]["goalsAwayTeam"] ?? 0);
//            $matchSaved->setPlayedAt(new \DateTime($match["api"]["fixtures"][0]["event_timestamp"]));
            $matchSaved->setPlayedAt(new \DateTime(DateTime::createFromFormat('d/M/Y H:i:s', $match["api"]["fixtures"][0]["event_timestamp"])));
            $matchSaved->setIsOver(false);
            $matchSaved->setStatus($match["api"]["fixtures"][0]["status"]);
            $matchSaved->setWinner($match["api"]["fixtures"][0]["statusShort"]);
            $matchSaved->setMatchId($match["api"]["fixtures"][0]["fixture_id"]);
            $matchSaved->setIsCustom(false);

            $entityManager->persist($matchSaved);
            $entityManager->flush();

        }

        if ($form->isSubmitted() && $form->isValid()) {
            if ((isset($matchSaved) && null !== $matchSaved) || (isset($existingMatch) && null !== $existingMatch))
            {
                $bet->setMatchToBet(isset($matchSaved) ? $matchSaved : $existingMatch);
                $bet->addUser($this->getUser());
                // todo: Mettre le group et filtre la requête SQL sur les groupes

                $entityManager->persist($bet);
                $entityManager->flush();
            }
        }

        return $this->render(
            'app/event/bet.html.twig',
            [
                'match' => $match["api"]["fixtures"],
                'form' => $form->createView(),
            ]
        );
    }
}
