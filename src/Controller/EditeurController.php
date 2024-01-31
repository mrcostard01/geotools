<?php

namespace App\Controller;

use App\Entity\Carte;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Entity\Modifications;
use App\Repository\CarteRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; 
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use FOS\CKEditorBundle\Form\Type\CKEditorType;


class EditeurController extends AbstractController
{
#[Route('editeur/{id}', name: 'editeur_Pays')]
public function create(Request $request, EntityManagerInterface $manager,CarteRepository $CarteRep, int $id) {
    //Sert à créer un formulaire pour effectuer une modification
    $Modifications = new Modifications();
    $form = $this->createFormBuilder($Modifications)
                 ->add('ancienneidpays', NumberType::class)
                 ->add('modifpaysdescm', CKEditorType::class, [
                    'label' => 'Modification du pays'
                 ])
                 ->add('Envoyer', SubmitType::class, [ 'row_attr' => ['id' => 'Mybutton']])
                 ->getForm();

    $form->handleRequest($request);
    //Sert à sauvegarder le formulaire
    if($form->isSubmitted() && $form->isValid()) {
        
        $manager->persist($Modifications);
        $manager->flush();
        $this->addFlash('success', 'Votre modification viens d\'être envoyée !');
        return $this->redirectToRoute('accueil');
    }
    //Sert à trouver le pays par id             
    $id = intval($id);
        
    $Pays = $CarteRep->findOneBy([
        'id'=> intval($id)
    ]);
    if (!$Pays){
        throw $this->createNotFoundException('page non trouvé');
    }
     
return $this->render('editeur/index.html.twig', [
            'formModifications' => $form->createView(),
            'controller_name' => 'EditeurController',
            'Pays' => $Pays,
        ]);     
    }
}    
   

