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
     * @Route("/groups", name="user.groups")
     * @param GroupBuilder $groupBuilder
     * @param Request      $request
     *
     * @return Response
     */
    public function index(GroupBuilder $groupBuilder, Request $request): Response
    {
        $groupFactory = new GroupBuilder();
        $group = new Group();
        $form = $this->createForm(GroupType::class);
        $user = $this->entityManager->getRepository(User::class)->find($this->getUser()->getId());
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $group->setToken($groupFactory->getToken());
            $group->setCreatedAt($groupFactory->getCreatedAt());
            $group->setIsActive($groupFactory->isActive());
            
            $this->entityManager->persist($group);
            $user->setGroupDefined($group);
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }
        
        return $this->render(
            'app/groups/index.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}
