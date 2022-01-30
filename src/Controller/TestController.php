<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Entity\Comment;
use App\Form\ArticleType;
use App\Form\CommentType;
use App\Service\VerificationComment;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

use function PHPUnit\Framework\returnSelf;;



class TestController extends AbstractController
{
   
    public function listArticle(ArticleRepository $articleRepository): Response
    {

        $articles = $articleRepository->findBy([
           'State' =>  'publie'
        ]);



        return $this->render('test/index.html.twig', [

            'articles' => $articles,
            'brouillon' => false


        ]);
    }


    public function vueArticle(Article $article, Request $request, EntityManagerInterface $manager, VerificationComment $verifService, FlashBagInterface $session)
    {
        $comment = new Comment();
        $comment->setArticle($article);

        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            if ($verifService->CommentaireNonAutorise($comment) === false) {
                $manager->persist($comment);

                $manager->flush();

                return $this->redirectToRoute('vue', ['id' => $article->getId()]);
            } else {
                $session->add("danger", "Le commentaire contient un mot interdit");
            }
        }

        return $this->render('test/vue.html.twig', [

            'article' => $article,
            'form' => $form->createView()
        ]);
    }




}
