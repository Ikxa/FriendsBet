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
        $user = $this->entityManager->getRepository(User::class)->find($this->getUser()->getId());
        $group = $user->getGroupDefined() ?? new Group();
        $form = $this->createForm(GroupType::class, $group);
        $userGroupName = NULL !== $user->getGroupDefined() ? $user->getGroupDefined()->getName() : NULL;
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
                
                return $this->redirectToRoute('user.groups');
            }
        } else {
            // L'utilisateur connecté a un groupe donc on affiche les informations de ce groupe avec un bouton "quitter".
            $members = $this->entityManager
                ->getRepository(User::class)
                ->findBy(['group_defined' => $group->getId()]);
        }
        
        return $this->render(
            'app/groups/index.html.twig',
            [
                'form' => !isset($userGroupName) ? $form->createView() : NULL,
                'group' => isset($userGroupName) ? $user->getGroupDefined() : NULL,
                'members' => $members ?? NULL,
            ]
        );
    }
    
    /**
     * @Route("/groups/{token}/leave", name="user.groups.leave")
     */
    public function leaveGroup(string $token)
    {
        $user = $this->entityManager
            ->getRepository(User::class)
            ->findOneBy(['id' => $this->getUser()]);
        $group = $this->entityManager
            ->getRepository(Group::class)
            ->findOneBy(['token' => $token]);
        
        if ($user->getGroupDefined()->getToken() === $group->getToken()) {
            $user->setGroupDefined(NULL);
            $group->setMembers((int)($group->getMembers() - 1));
            
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }
        
        return $this->redirectToRoute('user.groups');
    }
    
    /**
     * @Route("/groups/join/{token}", name="user.groups.join")
     * @param string $token
     */
    public function join(string $token)
    {
        $user = $this->entityManager
            ->getRepository(User::class)
            ->findOneBy(['id' => $this->getUser()]);
        $group = $this->entityManager
            ->getRepository(Group::class)
            ->findOneBy(['token' => $token]);
        
        $group->setMembers((int)($group->getMembers() + 1));
        $user->setGroupDefined($group);
        
        $this->entityManager->persist($group);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        
        return $this->redirectToRoute('user.groups');
    }
}
