<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Article;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="article.index")
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
     * @Route("/show/{id}", name="article.show")
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
     * @Route("/articleCreate", name="article.create")
     */
    public function addArticle(Request $request, ObjectManager $manager)
    {
        $article = new Article();

        $form = $this->createFormBuilder($article)
                     ->add('title')
                     ->add('content') 
                     ->add('image')  
                     ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $article->setCreatedAt(new \DateTime());
            $manager->persist($article);
            $manager->flush();

            
            return $this->redirectToRoute('article.show', ['id' => $article->getId()]);
        }
        
   
        
        
        return $this->render('home/addArticle.html.twig', [
            'controller_name' => 'HomeController',
            'formArticle' => $form->createView()
        ]);
    }

     /**
     * @Route("/articleStore", name="article.store")
     */
    public function store(Request $request, ObjectManager $manager)
    {
        if($request->request->count() > 0) {
            $article = new Article();
            $article->setTitle($request->request->get('title'))
            ->setContent($request->request->get('content'))
            ->setImage($request->request->get('image'))
            ->setCreatedAt(new \DateTime());

            $manager->persist($article);
            $manager->flush();

            return $this->render('home/show.html.twig', [
                'controller_name' => 'HomeController',
                'article' => $article
            ]);

        }

        return $this->render('home/addArticle.html.twig');
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
