<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Game;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\GameRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(GameRepository $gameRepository, CategoryRepository $categoryRepository): Response
    {   
        $allGames = $gameRepository->findAll();
        $allCategories = $categoryRepository->findAll();
        $user = $this->getUser();
        return $this->render('home/index.html.twig', [
            'allGames' => $allGames,
            'allCategories' => $allCategories,
            'user' => $user,
        ]);
    }

    /**
     * @Route("/game/favorite/{id}", name="app_favorite")
     */
    public function addFavorite(Request $request, $id, EntityManagerInterface $em, GameRepository $gameRepository, CategoryRepository $categoryRepository): Response
    {   
        $user = $this->getUser();
        $allGames = $gameRepository->findAll();
        $allCategories = $categoryRepository->findAll();

        $favorite = new Game;
        $game = $gameRepository->findOneBy(['id' => $id]);
        $game->handleRequest($request);
        $favorite = $this->addFavorite($game);

        $em->persist($favorite);
        $em->flush();

        
             /*REDIRECT TO ADMIN HOME*/ 
             return $this->redirectToRoute('app_home',[
                'user' => $user,
            ]);
       
        return $this->render('home/index.html.twig', [
            'game' => $game,
            'user' => $user,
            'allGames' => $allGames,
            'allCategories' => $allCategories,
        ]);
    }
}
