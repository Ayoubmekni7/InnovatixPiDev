<?php

namespace App\Form;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('id')
       ->add('name', null, [
      'constraints' => [
        new Assert\NotBlank(['message' => 'Le nom est obligatoire.']),
        new Assert\Length([
            'min' => 2,
            'max' => 255,
            'minMessage' => 'Le nom doit contenir au moins {{ limit }} caractères.',
            'maxMessage' => 'Le nom ne peut pas dépasser {{ limit }} caractères.'
        ])
    ]
])
->add('email', null, [
    'constraints' => [
        new Assert\NotBlank(['message' => 'L\'adresse email est obligatoire.']),
     
    ]
])
->add('password', null, [
    'constraints' => [
        new Assert\NotBlank(['message' => 'Le mot de passe est obligatoire.']),
        // Ajoutez ici d'autres contraintes si nécessaire
    ]
])
->add('cin', null, [
    'constraints' => [
        new Assert\Length([
            'min' => 8,
            'max' => 8,
            'exactMessage' => 'Le numéro de CIN doit contenir exactement {{ limit }} chiffres.'
        ])
    ]
])
->add('dateNaissance')
->add('tel', null, [
    'constraints' => [
        new Assert\Regex([
            'pattern' => '/^\d{8}$/',
            'message' => 'Le numéro de téléphone doit être composé de 8 chiffres.'
        ])
    ]
])
           /* ->add('photo' FileType::class, [
    'constraints' => [
        new Assert\File([
            'maxSize' => '5M', // Taille maximale du fichier
            'mimeTypes' => [
                'image/jpeg',
                'image/png',
                'application/pdf', // Ajoutez le type MIME pour les fichiers PDF
            ],
            'mimeTypesMessage' => 'Veuillez télécharger une image ou un fichier PDF valide.', // Message d'erreur si le type MIME n'est pas valide
        ]),
    ],
])*/
            ->add('adresse')
            ->add('salaire')
    
            ->add('poste')
            ->add('departement',ChoiceType::class, [
                'choices' => [
                    'Département 1' => 'RH',
                    'Département 2' => 'Finance',
                    'Département 2' => 'IT',
                    'Département 2' => 'scoring',
                    'Département 2' => 'credit',
                    'Département 2' => 'projet',

                    // Ajoutez les autres départements ici
                ],
                'placeholder' => 'Sélectionnez un département',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Veuillez sélectionner un département.',
                    ]),
                ],
            ])
            ->add('dateEambauche')
            //->add('typeStage')
            //->add('dureeStage')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
