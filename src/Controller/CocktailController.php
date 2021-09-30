<?php

namespace App\Controller;

use App\Entity\Cocktail;
use App\Form\CocktailType;
use App\Repository\CocktailRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cocktail")
 */
class CocktailController extends AbstractController
{
    /**
     * @Route("/", name="cocktail_index", methods={"GET"})
     */
    public function index(CocktailRepository $cocktailRepository): Response
    {
        return $this->render('cocktail/index.html.twig', [
            'cocktails' => $cocktailRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="cocktail_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $cocktail = new Cocktail();
        $form = $this->createForm(CocktailType::class, $cocktail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cocktail);
            $entityManager->flush();

            return $this->redirectToRoute('cocktail_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cocktail/new.html.twig', [
            'cocktail' => $cocktail,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="cocktail_show", methods={"GET"})
     */
    public function show(Cocktail $cocktail): Response
    {
        return $this->render('cocktail/show.html.twig', [
            'cocktail' => $cocktail,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="cocktail_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Cocktail $cocktail): Response
    {
        $form = $this->createForm(CocktailType::class, $cocktail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cocktail_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cocktail/edit.html.twig', [
            'cocktail' => $cocktail,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="cocktail_delete", methods={"POST"})
     */
    public function delete(Request $request, Cocktail $cocktail): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cocktail->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($cocktail);
            $entityManager->flush();
        }

        return $this->redirectToRoute('cocktail_index', [], Response::HTTP_SEE_OTHER);
    }
}
