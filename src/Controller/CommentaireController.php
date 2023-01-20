<?php

namespace App\Controller;

use DateTime;
use App\Form\CommentaireType;
use App\Repository\CommentaireRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommentaireController extends AbstractController
{
    #[Route('/commentaire_update_{id<\d+>}', name: 'app_commentaire_update')]

    public function update($id, Request $request, CommentaireRepository $repo)
    {
        $commenatire = $repo->find($id);;
        $form = $this->createForm(CommentaireType::class, $commenatire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commenatire->setDateDeModification(new DateTime("now"));
            $repo->save($commenatire, 1);
            return $this->redirectToRoute('app_article', ['id' => $commenatire->getArticle()->getId()]);
        }

        return $this->render('article/oneArticle.html.twig', [
            //on crée la vue du formulaire pour l'afficher dans le template
            'formCommentaire' => $form->createView(),
            'article' => $commenatire->getArticle(),
            'commentaires' => $commenatire->getArticle()->getCommentaires()
        ]);
    }

    #[Route('/commentaire_delete_{id<\d+>}', name: 'app_commentaire_delete')]
    public function delete($id,  CommentaireRepository $repo)
    {
        $commenatire = $repo->find($id);

        $repo->remove($commenatire, 1);
        return $this->redirectToRoute('app_article', ['id' => $commenatire->getArticle()->getId()]);
    }
}
