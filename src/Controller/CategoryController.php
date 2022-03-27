<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;
use App\Repository\GameRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category/{slug}", name="app_category")
     */
    public function show($slug, GameRepository $gameRepository, CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->findOneBy(['slug' => $slug]);
        
        $allGames = $gameRepository->findBy(['category' => $category->getId()]);
        
        $allCategories = $categoryRepository->findAll();
        $user = $this->getUser();

        return $this->render('category/index.html.twig', [
            'user' => $user,
            'category' => $category,
            'allGames' => $allGames,
            'allCategories' => $allCategories,
        ]);
    }

    /**
     * @Route("/admin/category/add", name="app_category_add")
     */
    public function add(Request $request, SluggerInterface $slugger, EntityManagerInterface $em, GameRepository $gameRepository, CategoryRepository $categoryRepository): Response
    {
       
        $category = new Category;
        /* CREATE FORM CATEGORY*/
        $form = $this->createForm(CategoryType::class , $category);
        /* CHECK FORM */
        $form->handleRequest($request);
        $user = $this->getUser();
        if ($form->isSubmitted() && $form->isValid($category)) {
            $category
                ->setSlug(strtolower($slugger->slug($category->getName())));
            $em->persist($category);
            $em->flush();
            /*REDIRECT TO ADMIN HOME*/ 
            return $this->redirectToRoute('app_admin',[
                'user' => $user,
            ]);
        }
        
        return $this->render('category/add.html.twig', [
            'user' => $user,
            'formView' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/categories/list", name="app_categories_list")
     */
    public function list(GameRepository $gameRepository, CategoryRepository $categoryRepository): Response
    {
        $allCategories = $categoryRepository->findAll();
        $user = $this->getUser();

        return $this->render('category/list.html.twig', [
            'user' => $user,
            'allCategories' => $allCategories,
        ]);
    }
    
    /**
     * @Route("/admin/categories/list/delete/{id}", name="app_category_delete")
     */
    public function delete(Request $request, $id, EntityManagerInterface $em, GameRepository $gameRepository, CategoryRepository $categoryRepository): Response
    {
        $allCategories = $categoryRepository->findAll();
        $category = $categoryRepository->findOneBy(['id' => $id]);
        
        $user = $this->getUser();
      
            $em->remove($category);
            $em->flush();

            return $this->redirectToRoute('app_admin',[
                'user' => $user,
            ]);
    
        return $this->render('category/list.html.twig', [
            'user' => $user,
            'category' => $category,
            'allCategories' => $allCategories,
        ]);  
    }


        /**
     * @Route("/admin/categories/list/edit/{id}", name="app_category_edit")
     */
    public function edit(Request $request, $id, SluggerInterface $slugger, EntityManagerInterface $em, GameRepository $gameRepository, CategoryRepository $categoryRepository): Response
    {
        $allCategories = $categoryRepository->findAll();

        $category = $categoryRepository->findOneBy(['id' => $id]);
        $form = $this->createForm(CategoryType::class , $category);
        $form->handleRequest($request);

        $user = $this->getUser();
      
        if ($form->isSubmitted() && $form->isValid($category)) {
            $category
                ->setSlug(strtolower($slugger->slug($category->getName())));
                
            $em->persist($category);
            $em->flush();
        
            return $this->redirectToRoute('app_admin',[
                'user' => $user,
            ]);
        }
    
        return $this->render('category/edit.html.twig', [
            'user' => $user,
            'category' => $category,
            'allCategories' => $allCategories,
            'formView' => $form->createView(),
        ]);  
    }
}

