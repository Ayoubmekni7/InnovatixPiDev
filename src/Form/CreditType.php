<?php

namespace App\Form;
use Symfony\Component\Form\Extension\Core\Type\DateType;

use App\Entity\Credit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    
        
        {
            $builder
                ->add('id_client')
                ->add('montant')
                ->add('statusclient')
                ->add('mensualite')
                ->add('datedebut', DateType::class, [
                    'widget' => 'single_text',
                    'html5' => true,
                    'format' => 'yyyy-MM-dd', // Specify the format here
                ])
                ->add('duree')
                ->add('taux')
                ->add('status')
                ->add('fraisretard')
            ;
        }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Credit::class,
        ]);
    }
}
