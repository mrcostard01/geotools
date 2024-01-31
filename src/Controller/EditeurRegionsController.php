<?php

namespace App\Controller;

use App\Entity\Regions;
use App\Entity\Modifications;
use App\Repository\RegionsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\NumberType; 
use Symfony\Component\Form\Extension\Core\Type\SubmitType; 
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class EditeurRegionsController extends AbstractController
{
    #[Route('editeur_regions/{id}', name: 'Editeur_Regions')]
public function create(Request $request, EntityManagerInterface $manager,RegionsRepository $RegionsRep, int $id) {
    //Sert à créer un formulaire
    $Modifications = new Modifications();
    $form = $this->createFormBuilder($Modifications)
                 ->add('ancienneidregions', NumberType::class)
                 ->add('modifregionsdescm', CKEditorType::class, [ 
                    'row_attr' => ['id' => 'Mytextearea'],
                    'label' =>'Modification de la région'
                    ])
                 ->add('Envoyer', SubmitType::class, [ 'row_attr' => ['id' => 'Mybutton']])
                 ->getForm();

    
    //Sert à sauvegarder le formulaire
   
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($Modifications);
            $manager->flush();
            $this->addFlash('success', 'Votre modification viens d\'être envoyée !');
            return $this->redirectToRoute('accueil');
        }
        
    //Sert à trouver la region par id             
    $id = intval($id);
        
    $Regions = $RegionsRep->findOneBy([
        'id'=> intval($id)
    ]);
    if (!$Regions){
        throw $this->createNotFoundException('page non trouvé');
    }
     
return $this->render('editeur_regions/index.html.twig', [
            'formModifications' => $form->createView(),
            'controller_name' => 'EditeurRegionsController',
            'Regions' => $Regions,
        ]);     
    }
}
