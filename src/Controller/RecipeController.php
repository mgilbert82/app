<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Form\RecipeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecipeController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/mes-recettes', name: 'app_my_recipe')]
    public function index(): Response
    {
        $recipe = $this->entityManager->getRepository(Recipe::class)->findAll();
        dd($recipe);

        if (!$recipe) {
            return $this->render('my_recipe/index.html.twig', [
                'recipe' => $recipe
            ]);
        }

        return $this->render('recipe/index.html.twig');
    }

    #[Route('/recette/{id}', name: 'app_recipe')]
    public function show_recipe($id): Response
    {
        $recipe = $this->entityManager->getRepository(Recipe::class)->findOneById($id);

        if (!$recipe) {
            return $this->redirectToRoute('app_recipe');
        }

        return $this->render('recipe/index.html.twig');
    }

    #[Route('/creer-une-recette', name: 'app_add_recipe')]
    public function add_recipe(Request $request): Response
    {
        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($recipe);
            $this->entityManager->flush();
        }
        return $this->render('recipe/add_recipe.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
