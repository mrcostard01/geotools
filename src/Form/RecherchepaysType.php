<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RecherchepaysType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
            $builder
                ->add('mots', SearchType::class,[
                'label' => 'Barre de recherche',
                'required' => false,
                'attr' =>[
                    'class'=> 'form-control',
                    'placeholder' => "Entrer le nom d'un pays"
                ]])
                ->add('Recherche', SubmitType::class)
    
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
