<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\OptionsResolver\OptionsResolver;


use Symfony\Component\Validator\Constraints as Assert;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('email', EmailType::class , [
                'attr' => [
                    'class' => 'form-control',
                    'minlenght' =>'5',
                    'maxlenght' =>'50',
                ],
                'label' => 'E-mail',
                'label_attr' => [
                    'class'=> 'form_label'
                ],
                'constraints'=> [
                    new Assert\NotBlank(),
                    new Assert\Email(),
                    new Assert\Length(['min'=> 5, 'max'=>50])
                ]
            ])
            ->add('PseudoU', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlenght' =>'5',
                    'maxlenght' =>'50',
                ],
                'label' => 'Pseudonyme',
                'label_attr' => [
                    'class'=> 'form_label'
                ],
                'constraints'=> [
                    new Assert\NotBlank(),
                    new Assert\Length(['min'=> 5, 'max'=>50])
                ]
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => 'Mot de passe'
                ],
                'second_options' => [
                    'label' => 'Confirmation de mot de passe'
                ],
                'invalid_message' => 'Les mots de passe ne correspondent pas'
            ])
            ->add('RGPDconsent', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez être en accord avec nos termes.',
                    ]),
                ],
                'label' => 'En m\'inscrivant à ce site j\'accepte que mes informations soit récupérées',
            ])
            ->add('inscription', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
