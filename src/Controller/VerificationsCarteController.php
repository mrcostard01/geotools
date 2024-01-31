<?php

namespace App\Controller;

use App\Entity\Modifications;
use App\Repository\ModificationsRepository;
use App\Entity\Carte;
use App\Repository\CarteRepository;
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


class VerificationsCarteController extends AbstractController
{
    #[Route('/verifications/carte', name: 'verifications_carte')]
    public function create(EntityManagerInterface $em,Request $request,ModificationsRepository $ModificationsRep, CarteRepository $CarteRep): Response
    {
        $repository = $em->getRepository( Modifications::class);
        $repositoryCarte= $em->getRepository(Carte::class);

        $modifPays = $repository->findAll(); 
        if (!$modifPays){
            return $this->render('verifications_carte/pasdemodifications.html.twig', [
                'controller_name' => 'VerificationsCarteController',]);
        }
        $pays = $repositoryCarte->findAll(); 
        if (!$pays){
            throw $this->createNotFoundException('Les tables sont vides');
        }
    $modifications = new Modifications();
    $form = $this->createFormBuilder($modifications)
                 /*->add('ancienneidpays',  NumberType::class)*/
                 ->add('id',  NumberType::class, [ 
                    'attr' =>['class' => 'idform'],
                    'label' => false
                 ])
                /* ->add('modifpaysdescm', CKEditorType::class, [
                    'attr' => ['id' => 'contenumodifications'],
                    'label' => 'modification du pays'
                     ])*/
                 ->add('Effacer', SubmitType::class, [
                    'attr' => ['class' => 'boutonannulation'],
                     ])
                 ->add('Valider', SubmitType::class, [ 
                    'attr' =>['class' => 'boutonvalidation'],
                    ])
                 ->getForm();
        //Sert à sauvegarder le formulaire
        $form->handleRequest($request);
        if ($form->getClickedButton() && 'Valider' === $form->getClickedButton()->getName()) {
           //$id = $modifications->getId();
           $validpays= $repository->valideModificationsPays($modifications->getId());
        }
        //supprime la modification
        if ($form->getClickedButton() && 'Effacer' === $form->getClickedButton()->getName())
        {
             //$id = $modifications->getId();
             
             $effacepays = $repository->annulerModification($modifications->getId());


        }

        return $this->render('verifications_carte/index.html.twig', [
            'formModifications' => $form->createView(),
            'controller_name' => 'VerificationsCarteController',
            'ModifPays' => $modifPays,
            'Pays' => $pays,
        ]);
    }
}
