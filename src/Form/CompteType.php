<?php

namespace App\Form;

use App\Entity\Compte;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
            ->add('StatutMarital',   ChoiceType::class, [
                'choices' => [
                    'Marié' => 'marie',
                    'Célibataire ' => 'celebataire',
                    'Divorcé ' => 'divorcé',
                    'Veuf ' => 'veuf',
                ],
                'placeholder' => 'Sélectionnez une option', // optionnel
                // Autres options du champ ChoiceType
            ])
            ->add('proffesion')
            ->add('nationalite')
            ->add('typeCompte', ChoiceType::class, [
                'choices' => [
                    'Epargne' => 'epargne',
                    'EpargnePlanifie ' => 'epargne planifié',
                    'Courant' => 'courant',
                ],
                'placeholder' => 'Sélectionnez une option', // optionnel
                // Autres options du champ ChoiceType
            ])
            ->add('Montant')
            ->add('NumeroTelephone')
            ->add('PreferenceCommunic', ChoiceType::class, [
                'choices' => [
                    'SMS' => 'sms',
                    'Email' => 'email',
                ],
                'expanded' => true, // Définit le champ comme des boutons radio
                'multiple' => false, // Seul un choix peut être sélectionné
                // Autres options du champ ChoiceType
            ])
            ->add('submit', SubmitType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Compte::class,
        ]);
    }
}
