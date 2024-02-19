<?php

namespace App\Form;

use App\Entity\Cheque;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChequeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('compte')
            ->add('RIB')
            ->add('Cin')
            ->add('NomPrenom')
            ->add('Email')
            ->add('Beneficiaire',  ChoiceType::class, [
                'choices' => [
                    'Paiement' => 'Paiement',
                    'PaiementEco' => 'PaiementEco',
                    'Personne' => 'Personne',
                ],
                'expanded' => true, // Définit le champ comme des boutons radio
                'multiple' => false, // Seul un choix peut être sélectionné
                // Autres options du champ ChoiceType
            ])
            ->add('telephone')
            ->add('Montant')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cheque::class,
        ]);
    }
}
