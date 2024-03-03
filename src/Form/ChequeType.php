<?php

namespace App\Form;

use App\Entity\Cheque;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChequeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('compte')
            ->add('Cin')
            ->add('photoCin', FileType::class, [
                'label' => 'Choisir une photo',
                'required' => true,
                'mapped' => false,
            ])
            ->add('NomPrenom')
            ->add('Email')
            ->add('date')
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
            ->add('signatureId')
            ->add('documentId')
            ->add('signerId')
            ->add('pdfSansSignature')


        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cheque::class,
        ]);
    }
}
