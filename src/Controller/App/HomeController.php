<?php

namespace App\Controller\App;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class HomeController extends AbstractController
{
    /**
     * @var ParameterBagInterface
     */
    private $params;
    
    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }
    
    /**
     * @Route("/", name="home.index")
     *
     * @return Response
     */
    public function index(): Response
    {
        $twig = 'app/home/index_not_logged.html.twig';
        $path = $this->params->get('public_path');
        $images = [];
        
        if ($this->getUser()) {
            $twig = 'app/home/index_logged.html.twig';
            $user = $this->getUser();
    
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
