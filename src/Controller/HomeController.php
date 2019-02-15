<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttopFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Article;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index()
    {
        $repoArticle = $this->getDoctrine()->getRepository(Article::class);
        $articles = $repoArticle->findAll();
        
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/show/{id}", name="show")
     */
    public function show($id)
    {
        $repo = $this->getDoctrine()->getRepository(Article::class);
        $article = $repo->find($id);

        return $this->render('home/show.html.twig', [
            'controller_name' => 'HomeController',
            'article' => $article
        ]);
    }

    /**
     * @Route("/addArticle", name="addArticle")
     */
    public function addArticle(ObjectManager $manager)
    {
        $article = new Article();

        $form = $this->createFormBuilder($article)
                     ->add('title')
                     ->add('content') 
                     ->add('image')  
                     
                     ->getForm();

        
        
        return $this->render('home/addArticle.html.twig', [
            'controller_name' => 'HomeController',
            'formArticle' => $form->createView()
        ]);
    }

    /**
     * @Route("/about", name="about")
     */
    public function about()
    {
        return $this->render('home/about.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    
}
