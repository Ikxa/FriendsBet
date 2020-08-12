<?php

namespace App\Controller\App;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Api\Football;
use Symfony\Contracts\Translation\TranslatorInterface;

class HomeController extends AbstractController
{
    /**
     * @var ParameterBagInterface
     */
    private $params;

    private $api;

    /**
     * @param ParameterBagInterface $param
     * @param Football $footballApi
     */
    public function __construct(ParameterBagInterface $params, Football $footballApi)
    {
        $this->params = $params;
        $this->api = $footballApi;
    }

    /**
     * @Route("/", name="home.index")
     *
     * @return Response
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $twig = 'app/home/index_not_logged.html.twig';
        $path = $this->params->get('public_path');
        $images = [];

        if ($this->getUser()) {
            $twig = 'app/home/index_logged.html.twig';
            $user = $this->getUser();

            $times = $this->api->getTimes();
            $uri = 'https://api.football-data.org/v2/competitions/FL1/matches/?dateFrom='.$times['startWeek'].'&'.'dateTo='.$times['endWeek'];
            $content = $this->api->sendRequest('GET', $uri);

            foreach ($content["matches"] as $match) {
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

            if ($handle = opendir($path[0] . DIRECTORY_SEPARATOR . 'league')) {
                while (false !== ($entry = readdir($handle))) {
                    $images[] = $entry;
                }
                $images = array_diff( $images, [".", ".."] );
                closedir($handle);
            }
        }

        return $this->render(
            $twig,
            [
                'user' => $user ?? null,
                'images' => $images ?? null,
            ]
        );
    }
}
