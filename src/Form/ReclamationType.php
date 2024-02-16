<?php

namespace App\Form;

use App\Entity\Reclamation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder


        ->add('nomAutRec' , TextType::class, [
            'attr' => [
                'placeholder' => 'Nom',
            ]
        ])

        ->add('adrRec',EmailType::class, [
            'attr' => [
                'placeholder' => 'Adresse',
            ]
        ])
        

         ->add('objetRec' , TextType::class, [
                'attr' => [
                'placeholder' => 'Objet',
                ]
            ])

            
            ->add('contenuRec',TextAreaType::class, [
                'attr' => [
                    'placeholder' => 'Saisir votre Réclamation',
                ]
            ])
            
            
            
            ->add('depRec',  ChoiceType::class, [
                'choices' => [
                    'RH' => 'RH',
                    'Finance' => 'Finance',
                    'Service Clients' => 'Service Clients',
                    'Crédits et prêts' => 'Crédits et prêts',
                ],
                'placeholder' => 'Sélectionnez une option', // optionnel
                ])
            
        ;
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
        ]);
    }
}
