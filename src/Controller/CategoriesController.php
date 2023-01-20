<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoriesController extends AbstractController
{
    #[Route('/categorie_add', name: 'app_categories-add')]
    public function add(Request $request, CategorieRepository $repo, SluggerInterface $slugger)
    {
        $categorie = new Categorie;
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //ajouter un vaaluer dans slug de la database
            $slug = $slugger->slug($form->get('nom')->getData());

            $categorie->setSlug($slug);
            $repo->save($categorie, 1);
            return $this->redirectToRoute("app_categories");
        }

        return $this->render('categories/formCategorie.html.twig', [
            'formCategorie' => $form->createView()
        ]);
    }
    #[Route('/categories', name: 'app_categories')]
    public function showAll(CategorieRepository $repo): Response
    {
        $categories = $repo->findAll();
        return $this->render(
            'categories/allCategories.html.twig',
            [
                'categories' => $categories
            ]
        );
    }

    #[Route('/categorie_update_{id<\d+>}', name: 'app_categorie_update')]

    public function update($id, Request $request, CategorieRepository $repo, SluggerInterface $slugger)
    {
        $categorie = $repo->find($id);;
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $slug = $slugger->slug($categorie->getNom());

            $categorie->setSlug($slug);

            $repo->save($categorie, 1);
            return $this->redirectToRoute("app_categories");
        }

        return $this->render('categories/formCategorie.html.twig', [
            'formCategorie' => $form->createView()
        ]);
    }
    #[Route('/categorie_delete_{id<\d+>}', name: 'app_categorie_delete')]
    public function delete($id, CategorieRepository $repo)
    {
        $categorie = $repo->find($id);

        $repo->remove($categorie, 1);
        return $this->redirectToRoute("app_categories");
    }
}
