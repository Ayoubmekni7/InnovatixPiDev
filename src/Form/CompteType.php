<?php

namespace App\Form;

use App\Entity\Compte;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Email')
            ->add('confirmationEmail')
            ->add('cin')
            ->add('DateDelivranceCin')
            ->add('nom')
            ->add('prenom')
            ->add('sexe', ChoiceType::class, [
                'choices' => [
                    'Femme' => 'femme',
                    'Homme' => 'homme',
                ],
                'expanded' => true, // Définit le champ comme des boutons radio
                'multiple' => false, // Seul un choix peut être sélectionné
                // Autres options du champ ChoiceType
            ])

            ->add('DateNaissance')
            ->add('proffesion')
            ->add('typeCompte', ChoiceType::class, [
                'choices' => [
                    'epargne' => 'Courant',
                    'epargnePlanifie ' => 'Epargne planifié',
                    'courant' => 'Courant',
                ],
                'placeholder' => 'Sélectionnez une option', // optionnel
                // Autres options du champ ChoiceType
            ])
            ->add('Montant')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Compte::class,
        ]);
    }
}
