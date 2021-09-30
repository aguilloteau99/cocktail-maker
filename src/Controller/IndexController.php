<?php

namespace App\Controller;

use App\Entity\Cocktail;
use App\Form\CocktailType;
use App\Repository\CocktailRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(CocktailRepository $repo): Response
    {
        return $this->render('index/index.html.twig', [
            'cocktails' => $repo->findAll(),
        ]);
    }

    /**
     * @Route("/ajouter", name="ajouter")
     */
    public function ajouter(CocktailRepository $repo): Response
    {
        $cocktail = new Cocktail();
        $formCocktail = $this->createForm(CocktailType::class, $cocktail);
        return $this->render('index/ajouter.html.twig', [
            'cocktails' => $repo->findAll(),
            'formCocktail' => $formCocktail->createView(),
        ]);
    }
}
