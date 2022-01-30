<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Form\ArticleType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use App\Controller\Response;


class AdminController extends AbstractController
{
 
    public function ajouter(Article $article = null, Request $request, EntityManagerInterface $manager, LoggerInterface $logger)
    {
        if ($article === null) {
            $article = new Article();
        }


        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            if( $form->get('brouillon')->isClicked()){
                $article->setState('brouillon');
            }
            else{
                $article->setState('publie');
            }

            if ($article->getId() === null) {
                $manager->persist($article);
            }
            $manager->flush();

            return $this->redirectToRoute('index');
        }
        return $this->render('test/ajout.html.twig', [
            'form' => $form->createview()
        ]);
    }

    public function delete(Article $article){
$em = $this->getDoctrine()->getManager();
$em->remove($article);
$em->flush();

// return new Response('Article supprimé');
    }
    
    public function brouillon(ArticleRepository $articleRepository){

        $articles= $articleRepository->findBy([
            'State' => 'brouillon'
        ]);
        return $this->render('test/index.html.twig', [

            'articles' => $articles,
            'brouillon' => true


        ]);
    }
  
}
