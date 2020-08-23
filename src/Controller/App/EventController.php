<?php

namespace App\Controller\App;

use App\Entity\App\Match;
use App\Api\Football;
use App\Form\App\MatchType;
use Doctrine\ORM\EntityManagerInterface;
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
     * @Route("/event/add", name="event.add")
     * @param EntityManagerInterface $em
     */
    public function add(EntityManagerInterface $em, Request $request): Response
    {
        $match = new Match();
        $form = $this->createForm(MatchType::class, $match);
        $form->handleRequest($request);
        
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
    
    
    /**
     * @Route("/event/bet", name="event.bet")
     */
    public function bet()
    {
        return new Response('Coucou');
    }
}
