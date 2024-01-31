<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Form\SearchArticlesType;
use App\Repository\ArticlesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;

class ArticlesController extends AbstractController
{
    

    #[Route('/article', name: 'articles')]
    public function index( ArticlesRepository $articleRep, Request $request): Response
    {   
        $form = $this->createForm(SearchArticlesType::class);
        $search = $form->handleRequest($request);

        $articles = $articleRep->findAll(); 
        if($form-> isSubmitted() && $form->isValid()){
            //On recherche les articles correspondant aux mots-clefs
            $articles = $articleRep->articleSearch($search-> get('mots')->getData());
            
          }

    return $this->render('articles/index.html.twig', [
        'controller_name' => 'AccueilController',
        
        'articles' => $articles,
        'form' => $form->createView()
        
    ]);
 }
    
#[Route('article/{id}', name: 'article_single')]
public function indexSingle(ArticlesRepository $ArticlesRep, int $id): Response
{

    $id = intval($id);
    
    $Articles = $ArticlesRep->findOneBy([
        'id'=> intval($id)
    ]);
    if (!$Articles){
        throw $this->createNotFoundException('page non trouvé');
    }
    return $this->render('Accueil/single.html.twig', [
        'controller_name' => 'HomeController',
        'Articles' => $Articles,
        
    ]);
}
  
}
