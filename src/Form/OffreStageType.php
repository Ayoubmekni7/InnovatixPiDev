<?php

namespace App\Form;

use App\Entity\OffreStage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OffreStageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('domaine',ChoiceType::class, [
        'choices' => [
            'Informatique' => 'Informatique',
            'Finance' => 'Finance',
            'Comptabilité' => 'Comptabilité',
            'Management' => 'Management',
            'Marketing' => 'Marketing',
            'RH' => 'RH',
        
        ],
        'placeholder' => 'Sélectionnez une option', // optionnel
        // Autres options du champ ChoiceType
    ])
            ->add('typeOffre')
            ->add('postePropose')
            ->add('experience')
            ->add('niveau')
            ->add('language')
            ->add('description')
            ->add('exigenceOffre')
            ->add('datePostu')
            ->add('motsCles', ChoiceType::class, [
                'choices' => [
                    'Java' => 'Java',
                    'Python' => 'Python',
                    'C++' => 'C++',
                    'Comptabilité' => 'Comptabilité',
                    'Banque' => 'Banque',
                    'Gestion de patrimoine' => 'Gestion de patrimoine',
                    // Ajoutez d'autres options selon vos besoins
                ],
                'multiple' => true, // Activez la sélection multiple
                'expanded' => false, // Désactivez l'affichage de la liste sous forme de boutons radio
                'placeholder' => 'Sélectionnez une ou plusieurs options', // Texte affiché par défaut
                'required' => false, // Désactivez la validation de champ obligatoire
            ])
            ->add('pfeBook',FileType::class, [
                'label' => 'Upload PDF file',
                'required' => true,
            
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OffreStage::class,
        ]);
    }
}

