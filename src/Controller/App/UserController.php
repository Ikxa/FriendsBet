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
        $form = $this->createForm(GroupType::class, $group);
        $user = $this->entityManager->getRepository(User::class)->find($this->getUser()->getId());
        $userGroupName = $user->getGroupDefined()->getName();
        $form->handleRequest($request);
        
        if (!isset($userGroupName) || empty($userGroupName)) {
            // L'utilisateur connecté n'a pas de groupe, il peut en créer un ou en rejoindre un via un token.
            if ($form->isSubmitted() && $form->isValid()) {
                $group->setToken($groupFactory->getToken());
                $group->setCreatedAt($groupFactory->getCreatedAt());
                $group->setIsActive($groupFactory->isActive());
                $group->setMembers(1);
                
                $this->entityManager->persist($group);
                $user->setGroupDefined($group);
                $this->entityManager->persist($user);
                $this->entityManager->flush();
            }
        } else {
            // L'utilisateur connecté a un groupe donc on affiche les informations de ce groupe avec un bouton "quitter".
        }
        
        return $this->render(
            'app/groups/index.html.twig',
            [
                'form' => !isset($userGroupName) ? $form->createView() : NULL,
                'group' => isset($userGroupName) ? $user->getGroupDefined() : NULL,
            ]
        );
    }
    
    /**
     * @Route("/groups/{token}/leave", name="user.groups.leave")
     */
    public function leaveGroup()
    {
    
    }
    
    /*
     * TODO : Créer une fonction qui récupère un token en url, affiche un bouton permettant de le rejoindre et défini le groupe du token à l'utilisateur
     */
}
