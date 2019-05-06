<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/article", name="article")
     */
    public function index() :  Response
    {
        $repo = $this->getDoctrine()->getRepository(Article::class);
       // dump($repo);
        $article = $repo->findAll();
        return $this->render('article/index.html.twig', [
        'article' => $article,
            'controller_name'=>'Articles'
        ]);
    }
    /**
     * @Route("/detail/{article}", name="article-detail")
     */
    public function showArticle(Article $article)
    {
        return $this->render('article/articledetail.html.twig', [
            'controller_name' => 'les détails de l\'article',
            'article'=> $article
        ]);
    }

    /**
     * @Route("/article/add", name="article-add", requirements={"article"="^(?!register).+"})
     */
    //@Route("/article/{article}", name="addarticle", requirements={"article"="^(?!register).+"})
    public function addArticle(Request $request)
    {
        $form = $this->createForm(ArticleType::class, new Article());
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();
        } else {
                return $this->render('admin/addarticle.html.twig', [
                'form' => $form->createView(),
                'errors' => $form->getErrors()

            ]);
        }
        return $this->render('home/index.html.twig') ;
    }

}
