<?php

namespace App\Controller\App;

use App\Entity\App\Group;
use App\Entity\Security\User;
use App\Form\App\GroupType;
use App\Service\GroupBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    
    /**
     * @inheritDoc
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
    *@Route("/user/profile", name="user.profile")
    **/
    public function profile()
    {
         return $this->render('app/user/profile.html.twig');
    }
}