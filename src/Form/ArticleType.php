<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use DateTime;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
           
            ->add('nomAutArt' , TextType::class, [
                'attr' => [
                    'placeholder' => 'Votre nom',
                ]
            ])
           
           
            ->add('dureeArt')
        
        
            ->add('titreArt' , TextType::class, [
                'attr' => [
                    'placeholder' => 'Titre',
                ]
            ])
           
            ->add('contenuArt',TextAreaType::class, [
                'attr' => [
                    'placeholder' => 'Contenu article',
                ]
            ])
            ->add('adrAutArt' , TextType::class, [
                'attr' => [
                    'placeholder' => 'Adresse',
                ]
            ])
            ->add('datePubArt', DateTimeType::class, [
                'widget' => 'single_text',
                'html5'=>true,
                'attr'=>['min'=>(new DateTime())->format('Y-m-d')],
            ])
            ->add('categorieArt',  ChoiceType::class, [
                'choices' => [
                    'RH' => 'RH',
                    'Finance' => 'Finance',
                    'Service Clients' => 'EFB',
                    'Crédits et prêts' => 'Autres',
                ],
                'placeholder' => 'Sélectionnez une option', // optionnel
                ])
              
               
                
                ->add('piecejointeArt' ,FileType::class,[
                    'label' => 'Choisir une piece jointe',
                    'data_class' => null,
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
