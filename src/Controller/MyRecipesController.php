<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MyRecipesController extends AbstractController
{
    #[Route('/mes-fiches-recettes', name: 'app_my_recipes')]
    public function index(): Response
    {
        return $this->render('recipe/my_recipes.html.twig', [
            'controller_name' => 'MyRecipesController',
        ]);
    }
}
