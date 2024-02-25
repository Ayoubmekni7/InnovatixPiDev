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
        ->add('name')
            ->add('email', null, [
                'constraints' => [
                    new Assert\Regex([
                        'pattern' => '/^[a-zA-Z0-9._%+-]+@gmail\.com$/',
                        'message' => 'L\'adresse email doit se terminer par "@gmail.com"',
                    ]),
                ],
            ])
           // ->add('roles')
            ->add('password',null, [
                'constraints' => [
                    new Assert\Length([
                        'min' => 8,
                        'minMessage' => 'Le mot de passe doit contenir au moins {{ limit }} caractères',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
                        'message' => 'Le mot de passe doit contenir au moins une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial',
                    ]),
                ],
            ])
          
            /*->add('cin',null, [
    'constraints' => [
        new Assert\Regex([
            'pattern' => '/^[0-9]{8}$/',
            'message' => 'Le numéro CIN doit être composé de 8 chiffres.',
        ]),
    ],
])*/
            ->add('dateNaissance' )
            ->add('tel',null, [
                'constraints' => [
                    new Assert\Regex([
                        'pattern' => '/^[0-9]{8}$/',
                        'message' => 'Le numéro de téléphone doit contenir 8 chiffres',
                    ]),
                ],
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
            ->add('salaire', null, [
                'constraints' => [
                    new Assert\Type([
                        'type' => 'numeric',
                        'message' => 'Veuillez saisir une valeur numérique',
                    ]),
                ],
            ])
            ->add('profession')
            ->add('poste')
            ->add('departement',ChoiceType::class, [
                'choices' => [
                    'Département 1' => 'Departement1',
                    'Département 2' => 'Departement2',
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
