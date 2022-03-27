<?php

namespace App\Controller;

use App\Entity\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\GameRepository;

class ProfilController extends AbstractController
{
    /**
     * @Route("/user/profil", name="app_profil")
     */
    public function index(GameRepository $gameRepository): Response
    {
        $user = $this->getUser();
        $allGames = $gameRepository->findAll();
    
         /* CHECK LOGGIN */
         if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('profil/index.html.twig', [
            'user' => $user,
            'allGames' => $allGames,
        ]);
    }
}
