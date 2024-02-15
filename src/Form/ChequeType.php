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
            ->add('numeroCompte')
            ->add('titulaireCompte')
            ->add('Beneficiaire',  ChoiceType::class, [
                'choices' => [
                    'Paiement' => 'Paiement',
                    'PaiementEco ' => 'Paiment Ecoresponsabilté',
                    'Personne' => 'Personne',
                ],
                'placeholder' => 'Sélectionnez une option', // optionnel
                // Autres options du champ ChoiceType
            ])
            ->add('NomBeneficiaire')
            ->add('Montant')
            ->add('telephone')
            ->add('Email')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cheque::class,
        ]);
    }
}
