<?php

namespace App\Form;

use App\Entity\Project;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('img', FileType::class, [
            'label' => 'Choisir une pièce jointe',
            'required' => false,
            'constraints' => [
                new File([
                    'mimeTypesMessage' => 'Veuillez uploader un fichier PDF valide',
                ])
            ],
        ])
            ->add('nomprojet')
            ->add('categorie')
            ->add('descriptionprojet')
            ->add('budgetprojet')
            ->add('datecreation')
            ->add('dureeprojet')
            ->add('statutprojet')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }




}
