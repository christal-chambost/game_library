<?php

namespace App\Controller;

use App\Entity\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="app_admin")
     */
    public function index(AccessDecisionManagerInterface $accessDecisionManagerInterface): Response
    {
        /*$token = new UsernamePasswordToken($user, 'none', 'none', $user->getRoles());

        if ($accessDecisionManager->decide($token, 'ROLE_ADMIN')) {
            // L'utilisateur $user a le rôle ROLE_ADMIN
        }
        
    //https://www.remipoignon.fr/symfony-comment-verifier-le-role-dun-utilisateur-en-respectant-la-hierarchie-des-roles/

        $this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')
                 /* CHECK LOGGIN */
      if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
      }

        $user = $this->getUser();

        return $this->render('admin/index.html.twig', [
            'user' => $user,
        ]);
    }
}
