<?php

namespace App\Controller\App;

use App\Entity\App\Match;
use App\Api\Football;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GroupsController extends AbstractController
{
    /**
    * @Route("/groups/index", name="groups.index")
    */
    public function index() {
        return new Response('Coucou');
    }
}