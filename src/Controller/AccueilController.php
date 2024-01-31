<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Repository\ArticlesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;


class AccueilController extends AbstractController
{
    #[Route('/', name: 'accueil')]
    public function index(EntityManagerInterface $em): Response
    {
        $repository = $em->getRepository( Articles::class);

        
        $articles = $repository->findBy(array(),array('id'=>'DESC') ); 
      
        
        return $this->render('Accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'articles' => $articles,
            
        ]);
    }
    #[Route('accueil/{id}', name: 'accueil_single')]
    public function indexSingle(ArticlesRepository $articlesRep, int $id): Response
    {

        $id = intval($id);
        
        $articles = $articlesRep->findOneBy([
            'id'=> intval($id)
        ]);
        if (!$articles){
            throw $this->createNotFoundException('page non trouvé');
        }
        return $this->render('Accueil/single.html.twig', [
            'controller_name' => 'HomeController',
            'articles' => $articles,
            
        ]);
    }
}
