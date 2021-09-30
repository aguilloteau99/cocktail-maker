<?php

namespace App\Controller;

use App\Entity\Cocktail;
use App\Entity\Couleur;
use App\Form\CocktailType;
use App\Repository\CocktailRepository;
use App\Repository\CouleurRepository;
use App\Repository\FruitRepository;
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
    public function ajouter(CocktailRepository $repoCocktail, CouleurRepository $repoCouleur): Response
    {
        $cocktail = new Cocktail();
        $formCocktail = $this->createForm(CocktailType::class, $cocktail);
        return $this->render('index/ajouter.html.twig', [
            'cocktails' => $repoCocktail->findAll(),
            'couleurs' => $repoCouleur->findAll(),
            'formCocktail' => $formCocktail->createView(),
        ]);
    }

    /**
     * @Route("/filtre-fruits-par-couleur/{id}", name="filtre-fruits-par-couleur", methods={"GET"})
     */
    public function filtreFruitsParCouleur(Couleur $couleur): Response
    {
        $json = [];
        foreach ($couleur->getFruits()->toArray() as $f){
            $json[] = array('id' => $f->getId(), 'nom' => $f->getNom());
        }
        return $this->json($json);
    }
}
