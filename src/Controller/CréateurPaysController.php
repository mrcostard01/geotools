<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Carte;
use App\Repository\CarteRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Vich\UploaderBundle\Form\Type\VichImageType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class CréateurPaysController extends AbstractController
{
    #[Route('/createur/pays', name: 'app_createur_pays')]
    public function index(Request $request, EntityManagerInterface $manager): Response
    {
    //Sert à créer un formulaire
    $Pays = new Carte();
    $form = $this->createFormBuilder($Pays)
                ->add('imageFile', VichImageType::class, [
                    'label' => 'Image Pays'
                 ])
                 ->add('titrepaysc', TextareaType::class, [
                    'label' => 'Titre du pays'
                 ])
                 ->add('capitalec', TextAreaType::class, [
                    'label' => 'Capitale du pays'
                 ])
                 ->add('descpaysc', CKEditorType::class, [
                    'label' => 'Description du pays'
                 ], [
                    'label' => 'Titre du pays'
                 ])
                 ->add('Envoyer', SubmitType::class)
                 ->getForm();

    $form->handleRequest($request);
    //Sert à sauvegarder le formulaire
    if($form->isSubmitted() && $form->isValid()) {
        $manager->persist($Pays);
        $manager->flush();
        $this->addFlash('success', 'Le pays a bien été créé !');
        return $this->redirectToRoute('accueil');
    }
        return $this->render('créateur_pays/index.html.twig', [
            'formPays' => $form->createView(),
            'Pays' => $Pays,
            'controller_name' => 'CréateurPaysController',
        ]);
    }
}
