<?php

namespace App\Controller;

use App\Entity\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\GameRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class UserController extends AbstractController
{

    /**
     * @Route("/user/favorite/add/{id}", name="app_user_add_favorite")
     */
    public function addFavorite($id, Request $request, EntityManagerInterface $em, GameRepository $gameRepository, CategoryRepository $categoryRepository): Response
    {
        $allGames = $gameRepository->findAll();
        $allCategories = $categoryRepository->findAll();
        
        $user = $this->getUser();
        $game = $gameRepository->findOneBy(['id' => $id]);

        $favorite = $user->addFavorite($game);
        $em->persist($favorite);
        $em->flush();

        $this->addFlash('Success','Added to favorites!!');
        
        return $this->render('home/index.html.twig', [
            'user' => $user,
            'allGames' => $allGames,
            'allCategories' => $allCategories,
        ]);        
    }

     /**
     * @Route("/user/favorite/remove/{id}", name="app_user_remove_favorite")
     */
    public function removeFavorite($id, Request $request, EntityManagerInterface $em, GameRepository $gameRepository, CategoryRepository $categoryRepository): Response
    {
        $allGames = $gameRepository->findAll();
        $allCategories = $categoryRepository->findAll();
        
        $user = $this->getUser();
        $game = $gameRepository->findOneBy(['id' => $id]);

        $favorite = $user->removeFavorite($game);
        $em->persist($favorite);
        $em->flush();
        
        $this->addFlash('Success','Added to favorites!!');
        
        return $this->render('home/index.html.twig', [
            'user' => $user,
            'allGames' => $allGames,
            'allCategories' => $allCategories,
        ]);        
    }

}