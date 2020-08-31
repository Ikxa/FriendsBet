<?php

namespace App\Controller\App;

use App\Entity\App\Match;
use App\Api\Football;
use App\Form\App\MatchType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class EventController
 *
 * @package App\Controller\App
 */
class EventController extends AbstractController
{

    /**
     * @Route("/event/bet", name="event.bet")
     */
    public function bet(): Response
    {
        return new Response('Coucou');
    }

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
     * @param PaginatorInterface $paginator
     *
     * @param Request            $request
     *
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request, Football $api): Response
    {
        $matchs = $this->getDoctrine()
            ->getRepository(Match::class)
            ->findAllScheduled();
        /*
         *
        $url = "https://api-football-v1.p.rapidapi.com/v2/teams";
        $response = $api->sendRequest('GET', $url);
        dd($response);
        */

        $matchsPaginated = $paginator->paginate(
            $matchs, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            20 // Nombre de résultats par page
        );
        
        return $this->render(
            'app/event/index.html.twig',
            [
                'matchs' => $matchsPaginated,
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
            $match->setPlayedAt(new \DateTime());
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
}
