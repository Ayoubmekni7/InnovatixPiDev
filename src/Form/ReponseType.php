<?php

namespace App\Form;

use App\Entity\Reponse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType; 
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use DateTime;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ReponseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
           
        ;
        $builder
        ->add('adrRep', TextType::class, [
            'label' => false,
            'attr' => ['class' => 'form-control bg-transparent', 'placeholder' => 'Votre adresse:']
        ])
        ->add('dateRep', DateTimeType::class, [
            'widget' => 'single_text',
            'html5'=>true,
            'attr'=>['min'=>(new DateTime())->format('Y-m-d')],
        ])
       
        
        ->add('contenuRep', TextareaType::class, [
            'label' => false,
            'attr' => ['class' => 'textarea_editor form-control bg-transparent', 'rows' => '15', 'placeholder' => 'Entrez votre réponse']
        ])

        ->add('pieceJRep' ,FileType::class,[
            'label' => 'Choisir une piece jointe',
            'data_class' => null,
        ])


       
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reponse::class,
        ]);
    }
}