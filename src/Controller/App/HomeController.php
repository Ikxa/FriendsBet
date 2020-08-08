<?php

namespace App\Controller\App;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home.index")
     * @param TranslatorInterface $translator
     *
     * @return Response
     */
    public function index(): Response
    {
        return $this->render(
            'app/home/index.html.twig',
            [
                'user' => $this->getUser()->getUsername(),
            ]
        );
    }
}
