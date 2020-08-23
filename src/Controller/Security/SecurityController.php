<?php

namespace App\Controller\Security;

use App\Entity\Security\User;
use App\Form\Security\SignupType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/signup", name="security.signup")
     * @param Request                      $request
     * @param UserPasswordEncoderInterface $encoder
     *
     * @return Response
     */
    public function signup(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User();
        $form = $this->createForm(SignupType::class, $user);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setCreatedAt(new \DateTime());
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $user->setIsActive(TRUE);
            $user->addRole('ROLE_USER');
            $em->persist($user);
            $em->flush();
            
            return $this->redirectToRoute('security.login');
        }
        
        return $this->render(
            'security/signup.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
    
    /**
     * @Route("/login", name="security.login")
     */
    public function login(): Response
    {
        return $this->render('security/login.html.twig');
    }
    
    /**
     * @Route("/logout", name="security.logout")
     */
    public function logout()
    {
        //todo : Route used to disconnect via logout
    }
}
