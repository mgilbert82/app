<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Form\RecipeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

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

        if (!$recipe) {
            return $this->render('my_recipe/index.html.twig', [
                'recipe' => $recipe
            ]);
        }

        return $this->render('recipe/all_recipe.html.twig');
    }

    #[Route('/recette/{id}', name: 'app_recipe')]
    public function show_recipe($id): Response
    {
        $recipe = $this->entityManager->getRepository(Recipe::class)->findOneById($id);

        if (!$recipe) {
            return $this->redirectToRoute('app_recipe');
        }

        return $this->render('recipe/recipe.html.twig');
    }

    #[Route('/creer-une-recette', name: 'app_add_recipe')]
    public function add_recipe(Request $request, SluggerInterface $slugger): Response
    {
        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);
        dump($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $date = new \DateTimeImmutable;
            $illustrationFile = $form->get('illustration')->getData();

            if ($illustrationFile) {
                $originalFilename = pathinfo(
                    $illustrationFile->getClientOriginalName(),
                    PATHINFO_FILENAME
                );

                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $illustrationFile->guessExtension();

                try {
                    $illustrationFile->move(
                        $this->getParameter('recipe_directory'),
                        $newFilename
                    );
                } catch (FileException $error) {
                    echo $error->getMessage();
                }

                $recipe->setIllustration($newFilename);
            }
            $recipe->setCreatedAt($date);
            $this->entityManager->persist($recipe);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_my_recipe');
        }
        return $this->render('recipe/add_recipe.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
