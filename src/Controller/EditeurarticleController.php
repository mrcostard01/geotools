<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Articles;
use App\Repository\ArticlesRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType; 
use Symfony\Component\Form\Extension\Core\Type\SubmitType; 
use Vich\UploaderBundle\Form\Type\VichImageType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\HttpFoundation\RedirectResponse;

class EditeurarticleController extends AbstractController
{
    #[Route('/editeurarticle', name: 'app_editeurarticle')]
    public function index(Request $request, EntityManagerInterface $manager): Response
    {   
    //On crée un formulaire pour rédiger un article
    $Articles = new Articles();
    $form = $this->createFormBuilder($Articles)
                 ->add('imageFile', VichImageType::class, [
                    'label' => 'Image'
                 ])
                 ->add('Titre_articlea', TextareaType::class, [
                    'label' => 'Titre de l\'article'
                 ])
                 ->add('Texte_articlea', CKEditorType::class, [
                    'label' => 'Texte de l\'article'
                 ])
                 ->add('Envoyer', SubmitType::class, [ 'row_attr' => ['id' => 'Mybutton']])
                 ->getForm();

    $form->handleRequest($request);

    //On sauvegarde le formulaire
    if($form->isSubmitted() && $form->isValid()) {
        $manager->persist($Articles);
        $manager->flush();
       
        return $this->redirectToRoute('accueil');
        
    }
        return $this->render('editeurarticle/index.html.twig', [
            'formArticles' => $form->createView(),
            'controller_name' => 'EditeurarticleController',
        ]);
    }
}
