<?php

namespace App\Form;

use App\Entity\Investissement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InvestissementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('montant')
            ->add('dateInvestissement')
            ->add('description')
            ->add('typeInvestissement')
            ->add('duree')
            ->add('tauxRendement')
            ->add('statut')
            ->add('createdAt')
            ->add('updatedAt')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Investissement::class,
        ]);
    }
}
