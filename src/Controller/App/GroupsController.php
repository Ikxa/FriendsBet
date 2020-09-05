<?php

namespace App\Controller\App;

use App\Entity\App\Bet;
use App\Entity\App\Group;
use App\Entity\Security\User;
use App\Form\App\GroupType;
use App\Service\GroupBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GroupsController extends AbstractController
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
     * @Route("/groups/index", name="groups.index")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function index(Request $request)
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

                return $this->redirectToRoute('groups.index');
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
     * @Route("/groups/{token}/leave", name="groups.leave")
     * @param string $token
     * @return RedirectResponse
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

        return $this->redirectToRoute('groups.index');
    }

    /**
     * @Route("/groups/join/{token}", name="groups.join")
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

        return $this->redirectToRoute('groups.index');
    }

    /**
     * @Route("/groups/settings", name="groups.settings")
     */
    public function settings()
    {
        $user = $this->entityManager->getRepository(User::class)->find($this->getUser()->getId());
        $group = $user->getGroupDefined() ?? new Group();

        return $this->render('app/groups/settings.html.twig', [
            'group' => $group,
        ]);
    }

    /**
     * @Route("/groups/stats", name="groups.stats")
     */
    public function stats()
    {
        $user = $this->entityManager->getRepository(User::class)->find($this->getUser()->getId());
        $group = $user->getGroupDefined() ?? new Group();

        return $this->render('app/groups/stats.html.twig', [
            'group' => $group,
        ]);
    }

    /**
     * @Route("/groups/history", name="groups.history")
     */
    public function history()
    {
        // todo : Récupérer les différents paris, les matchs pariés pour avoir le status
        $betsWithMatch = $this->getDoctrine()
            ->getRepository(Bet::class)
            ->findAllBetsWithMatchsByUser();

        return $this->render('app/event/history.html.twig', [
            'betsWithMatch' => $betsWithMatch,
        ]);
    }

}
