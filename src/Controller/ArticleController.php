<?php

namespace App\Controller;

use DateTime;
use App\Entity\Article;
use App\Entity\Categorie;
use App\Form\ArticleType;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\ArticleRepository;
use App\Repository\CategorieRepository;
use App\Repository\CommentaireRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


// 



class ArticleController extends AbstractController
{
    #[Route('/articles', name: 'app_articles')]
    public function showAll(ArticleRepository $repo, CategorieRepository $repoCat): Response
    {
        // on récupere les articles en passant par un objet de l'ArticleRepository et en utilisant la methode findall()
        $articles = $repo->findAll();
        $categories = $repoCat->findAll();


        // dd() equivalent d'un var_dump et die() en meme temps
        return $this->render(
            'article/allArticles.html.twig',
            [
                'articles' => $articles,
                'categories' => $categories
            ]
        );
    }
    #[Route('/articles_categorie{slug}', name: 'app_article_by_category')]
    public function showByCategory($slug, CategorieRepository $repo)
    {
        $categorie = $repo->findOneBy(['slug' => $slug]);
        $categories = $repo->findAll();

        return $this->render(
            'article/allArticles.html.twig',
            [
                'articles' => $categorie->getArticless(),
                'categories' => $categories
            ]
        );
    }
    // <\d+> est une regex qui permet de dire que l'information qu'on met dans l'id doit être un entier de 1 à l'infini. sans quoi cette route pourrait être confondu avec d'autres. ex: la route suivante /article_add, le add aurait été pris pour un id et donc intercepté avant d'y arrivé 
    #[Route('/article_{id<\d+>}', name: 'app_article')]
    public function show($id, ArticleRepository $repo, Request $request, CommentaireRepository $repoCmt)
    {
        $article = $repo->find($id);
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $commentaire->setDateDeCreation(new DateTime("now"));
            $commentaire->setArticle($article);
            $repoCmt->save($commentaire, 1);
            return $this->redirectToRoute('app_article', ['id' => $id]);
        }

        return $this->render(
            'article/oneArticle.html.twig',
            [
                'article' => $article,
                'formCommentaire' => $form->createView()
            ]
        );
    }

    #[Route('/article_add', name: 'app_article_add')]
    public function add(Request $request, ArticleRepository $repo)
    {
        //on crée un pbjet de la class Article
        $article = new Article();


        //on crée le formulaire en liant le ArticleType à l'objet $article
        $form = $this->createForm(ArticleType::class, $article);

        //on donne accés aux donnée post du formulaire
        $form->handleRequest($request); // $request obj de la class Request q'on a ajouter dans le paramete de la fonction add 

        // pour verfier que le form est envoye 
        if ($form->isSubmitted() && $form->isValid()) {

            $article->setDateDeCreation(new DateTime("now"));

            //la methode save permet de faire un persist puis un flush en ajoutant le 2eme parametre 1 = true et elle se trouve dans le repository ArticleRepository
            $repo->save($article, 1);

            return $this->redirectToRoute("app_articles");
        }

        return $this->render('article/fromArticle.html.twig', [
            //on crée la vue du formulaire pour l'afficher dans le template
            'formArticle' => $form->createView()
        ]);
    }

    #[Route('/article_update_{id<\d+>}', name: 'app_article_update')]

    public function update($id, Request $request, ArticleRepository $repo)
    {
        //on crée un pbjet de la class Article
        $article = $repo->find($id);;


        //on crée le formulaire en liant le ArticleType à l'objet $article
        $form = $this->createForm(ArticleType::class, $article);

        //on donne accés aux donnée post du formulaire
        $form->handleRequest($request); // $request obj de la class Request q'on a ajouter dans le paramete de la fonction add 

        // pour verfier que le form est envoye 
        if ($form->isSubmitted() && $form->isValid()) {

            $article->setDateDeModification(new DateTime("now"));

            //la methode save permet de faire un persist puis un flush en ajoutant le 2eme parametre 1 = true et elle se trouve dans le repository ArticleRepository
            $repo->save($article, 1);

            return $this->redirectToRoute("app_articles");
        }

        return $this->render('article/fromArticle.html.twig', [
            //on crée la vue du formulaire pour l'afficher dans le template
            'formArticle' => $form->createView()
        ]);
    }

    #[Route('/article_delete_{id<\d+>}', name: 'app_article_delete')]
    public function delete($id, ArticleRepository $repo)
    {
        $article = $repo->find($id);

        $repo->remove($article, 1);
        return $this->redirectToRoute("app_articles");
    }
}
