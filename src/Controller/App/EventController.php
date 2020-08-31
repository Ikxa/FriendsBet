<?php

namespace App\Controller\App;

use App\Entity\App\Match;
use App\Api\Football;
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
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $matchsUrl = 'https://api-football-v1.p.rapidapi.com/v2/fixtures/league/2664/next/50?timezone=Europe/Paris';
        $matchs = $this->api->sendRequest('GET', $matchsUrl);

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
     * @param int $id
     *
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     *
     * @return Response
     */
    public function bet(int $id): Response
    {
        dump($id);

        $matchSelectedUrl = 'https://api-football-v1.p.rapidapi.com/v2/fixtures/id/'.$id.'?timezone=Europe/Paris';
        $match = $this->api->sendRequest('GET', $matchSelectedUrl);

        return $this->render(
            'app/event/bet.html.twig',
            [
                'match' => $match["api"]["fixtures"],
            ]
        );
    }
}
