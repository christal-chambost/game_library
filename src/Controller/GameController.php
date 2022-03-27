<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Game;
use App\Form\GameType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\GameRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class GameController extends AbstractController
{
    /**
     * @Route("/game/{id}", name="app_game")
     */
    public function index (int $id, GameRepository $GameRepository): Response
    {
        $game = $GameRepository->findOneBy(['id' => $id]);
        $category = $game->getCategory();


        $user = $this->getUser();
        return $this->render('game/index.html.twig', [
            'game' => $game,
            'user' => $user,
            'category' => $category,
        ]);
    }

        /**
     * @Route("/admin/game/add", name="app_game_add")
     */
    public function add(Request $request, SluggerInterface $slugger, EntityManagerInterface $em, GameRepository $gameRepository, CategoryRepository $categoryRepository): Response
    {

        $game = new Game;
        /* CREATE FORM game*/
        $form = $this->createForm(GameType::class , $game);
        /* CHECK FORM */
        $form->handleRequest($request);
        $user = $this->getUser();
        if ($form->isSubmitted() && $form->isValid($game)) {
            $game
                ->setSlug(strtolower($slugger->slug($game->getName())));
            $em->persist($game);
            $em->flush();
            /*REDIRECT TO ADMIN HOME*/ 
            return $this->redirectToRoute('app_admin',[
                'user' => $user,
            ]);
        }
        
        return $this->render('game/add.html.twig', [
            'user' => $user,
            'formView' => $form->createView(),
        ]);
    }


        /**
     * @Route("/admin/games/list", name="app_games_list")
     */
    public function list(Request $request, EntityManagerInterface $em, GameRepository $gameRepository, CategoryRepository $categoryRepository): Response
    {
        $allGames = $gameRepository->findAll();
        $user = $this->getUser();
       
        
        return $this->render('game/list.html.twig', [
            'user' => $user,
            'allGames' => $allGames,
        ]);
    }
    
    /**
     * @Route("/admin/games/list/delete/{id}", name="app_game_delete")
     */
    public function delete(Request $request, $id, EntityManagerInterface $em, GameRepository $gameRepository, CategoryRepository $categoryRepository): Response
    {
        $allGames = $gameRepository->findAll();
        $game = $gameRepository->findOneBy(['id' => $id]);

        $user = $this->getUser();
      
            $em->remove($game);
            $em->flush();

            return $this->redirectToRoute('app_admin',[
                'user' => $user,
            ]);
        
    
        return $this->render('game/list.html.twig', [
            'user' => $user,
            'game' => $game,
            'allGames' => $allGames,
        ]);  
    }

     /**
     * @Route("/admin/games/list/edit/{id}", name="app_game_edit")
     */
    public function edit(Request $request, $id, SluggerInterface $slugger, EntityManagerInterface $em, GameRepository $gameRepository, CategoryRepository $categoryRepository): Response
    {
        $allGames = $gameRepository->findAll();

        $game = $gameRepository->findOneBy(['id' => $id]);
        $form = $this->createForm(GameType::class , $game);
        $form->handleRequest($request);

        $user = $this->getUser();
      
        if ($form->isSubmitted() && $form->isValid($game)) {
            $game
                ->setSlug(strtolower($slugger->slug($game->getName())));
                
            $em->persist($game);
            $em->flush();
        
            return $this->redirectToRoute('app_admin',[
                'user' => $user,
            ]);
        }
    
        return $this->render('game/edit.html.twig', [
            'user' => $user,
            'game' => $game,
            'allGames' => $allGames,
            'formView' => $form->createView(),
        ]);  
    }
}
