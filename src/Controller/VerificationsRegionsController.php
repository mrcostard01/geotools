<?php

namespace App\Controller;

use App\Entity\Modifications;
use App\Repository\ModificationsRepository;
use App\Entity\Regions;
use App\Repository\RegionsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType; 
use Symfony\Component\Form\Extension\Core\Type\ButtonType; 
use Symfony\Component\Form\Extension\Core\Type\SubmitType; 
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class VerificationsRegionsController extends AbstractController
{
    
        #[Route('/verifications/regions', name: 'verifications_regions')]
        public function create(EntityManagerInterface $em,Request $request,ModificationsRepository $ModificationsRep, RegionsRepository $regionRep): Response
        {
            
            
            $repository = $em->getRepository( Modifications::class);
            $repositoryRegions= $em->getRepository(Regions::class);
    
            $modifRegions = $repository->findAll(); 
            if (!$modifRegions ){
                return $this->render('verifications_carte/pasdemodifications.html.twig', [
                    'controller_name' => 'VerificationsRegionsController',]);
            }
    
            $regions= $repositoryRegions->findAll(); 
            if (!$regions){
                throw $this->createNotFoundException('Les tables sont vides');
            }
            
    
            
        $modifications = new Modifications();
        $form = $this->createFormBuilder($modifications)
                     //->add('ancienneidregions',  NumberType::class)
                     ->add('id',  NumberType::class, [ 
                        'attr' => ['class' => 'idform'],
                        'label' => false
                        ])
                     /*->add('modifregionsdescm', CKEditorType::class, [
                        'attr' => ['id' => 'contenumodifications'],
                        'label' => 'modification de la régions'
                         ])*/
                     ->add('Effacer', SubmitType::class, [
                        'attr' => ['class' => 'boutonannulation'],
                         ])
                     ->add('Valider', SubmitType::class, [ 'attr' => ['class' => 'boutonvalidation']])
                     ->getForm();
    
        
            
    
            //Sert à sauvegarder le formulaire
       
            $form->handleRequest($request);
            if ($form->getClickedButton() && 'Valider' === $form->getClickedButton()->getName()) {
                //$id = $modifications->getId();
                
     
                $validpays= $repository->valideModificationsRegions($modifications->getId());

             }
             //supprime la modification
             if ($form->getClickedButton() && 'Effacer' === $form->getClickedButton()->getName())
             {
                $effacepays = $repository->annulerModification($modifications->getId());
     
             }
    
            return $this->render('verifications_regions/index.html.twig', [
                'formModifications' => $form->createView(),
                'controller_name' => 'VerificationsRegionsController',
                'ModifRegions' => $modifRegions,
                'Regions' => $regions,
            ]);
        }
}
