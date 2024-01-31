<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Entity\Regions;
use App\Repository\RegionsRepository;
use App\Entity\Carte;
use App\Repository\CarteRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CréateurRegionsController extends AbstractController
{
    
    
        #[Route('/createur/regions', name: 'app_createur_regions')]
    public function index(Request $request, EntityManagerInterface $manager, RegionsRepository $RegionsRep, CarteRepository $CarteRep): Response
    {


        $repository = $manager->getRepository( Regions::class);
      
        $Regions = $repository->findAll(); 
        
    //Sert à créer un formulaire pour créer une page régions
  
    $repositorycarte= $manager->getRepository( Carte::class);
    $Carte = $repositorycarte->findAll(); 
    $FormRegions = new Regions();
    $form = $this->createFormBuilder($FormRegions)
                 ->add('regionstitrer', TextareaType::class, [
                    'label' => 'Titre de la régions'
                 ])
                 ->add('cartertitre', EntityType::class, [
                    'class' => Carte::class ,
                    'choices' => $Carte,
                    'label' => 'De quel pays fait parti la région ?'
                    ])
                 ->add('descregionsr', CKEditorType::class, [
                    'label' => 'Description de la région'
                 ])
                 ->add('Envoyer', SubmitType::class, [ 'row_attr' => ['id' => 'Mybutton']])
                 ->getForm();
            $repository = $manager->getRepository( Regions::class);
      
        $Regions = $repository->findAll(); 
    $form->handleRequest($request);
    //Sert à sauvegarder le formulaire
    
    if($form->isSubmitted() && $form->isValid()) {
        
        
        $manager->persist($FormRegions);
        $manager->flush();
        $this->addFlash('success', 'La région a bien été créé !');
        return $this->redirectToRoute('accueil');
    }
        return $this->render('créateur_regions/index.html.twig', [
            'formRegions' => $form->createView(),
            'Regions' => $Regions,
            'controller_name' => 'CréateurRegionsController',
        ]);
    }
    }

