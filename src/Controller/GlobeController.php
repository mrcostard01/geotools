<?php

namespace App\Controller;

use App\Entity\Carte;
use App\Repository\CarteRepository;
use App\Form\RecherchepaysType;
use App\entity\Regions;
use App\Repository\RegionsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class GlobeController extends AbstractController
{
    #[Route('/globe', name: 'app_globe')]
    public function index(CarteRepository $carteRep, Request $request): Response
    {
        $form = $this->createForm(RecherchepaysType::class);
        $search = $form->handleRequest($request);
      
        $pays = $carteRep->findAll(); 
        if($form-> isSubmitted() && $form->isValid()){
            //On recherche les pays correspondant aux mots-clefs
            $pays = $carteRep->searchpays($search -> get('mots')
            ->getData());
            foreach ($pays as $pay) {
            $pay->getDescPaysC();
            }
        }
       
        if (!$pays){
            throw $this->createNotFoundException('Les tables sont vides');
        }
        return $this->render('globe/index.html.twig', [
            'controller_name' => 'GlobeController',
            'Pays' => $pays,
            'form' => $form->createView()
        ]);
    }
    #[Route('/globe/{id}', name: 'globe_single')]
    public function indexSingle(CarteRepository $CarteRep, RegionsRepository $RegionsRep, int $id): Response
    {
        $id = intval($id);
        
        $Pays = $CarteRep->findOneBy([
            'id'=> intval($id)
        ]);
        if (!$Pays){
            throw $this->createNotFoundException('page non trouvé ');
        }
      
        $Regions = $RegionsRep->findBy([
            'carte_r_titre'=> intval($id)
        ]);
    
        if (!$Regions){
            return $this->render('globe/PaysSeulement.html.twig', [
                'controller_name' => 'GlobeController',
                'Pays' => $Pays,]);
        }
        return $this->render('globe/single.html.twig', [
            'controller_name' => 'GlobeController',
            'Pays' => $Pays,
            'Regions' => $Regions]);
    }

    
   
}
