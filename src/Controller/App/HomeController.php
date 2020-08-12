<?php

namespace App\Controller\App;

use App\Entity\App\Match;
use App\Entity\App\Sport;
use App\Entity\Warm;
use App\Service\MatchManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Api\Football;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class HomeController extends AbstractController
{
    /**
     * @var ParameterBagInterface
     */
    private $params;
    
    /**
     * @param Football              $footballApi
     * @param ParameterBagInterface $params
     */
    public function __construct(ParameterBagInterface $params, Football $footballApi)
    {
        $this->params = $params;
        $this->api = $footballApi;
    }
    
    /**
     * @Route("/", name="home.index")
     *
     * @param MatchManager $matchManager
     *
     * @return Response
     */
    public function index(MatchManager $matchManager): Response
    {
        $twig = 'app/home/index_not_logged.html.twig';
        $path = $this->params->get('public_path');
        $images = [];
        
        if ($this->getUser()) {
            $twig = 'app/home/index_logged.html.twig';
            $user = $this->getUser();
            $matchManager->addMatchBetweenDates();
    
            if ($handle = opendir($path[0].DIRECTORY_SEPARATOR.'league')) {
                while (FALSE !== ($entry = readdir($handle))) {
                    $images[] = $entry;
                }
                $images = array_diff($images, [".", ".."]);
                closedir($handle);
            }
        }
        
        return $this->render(
            $twig,
            [
                'user' => $user ?? NULL,
                'images' => $images ?? NULL,
            ]
        );
    }
}
