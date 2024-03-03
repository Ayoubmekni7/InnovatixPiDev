<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\File;
use App\Entity\Credit;
use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class CreditType extends AbstractType
{
    private $security;
    
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $this->security->getUser();

        $builder
        
        ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $credit = $event->getData();
            $user = $this->security->getUser();
            
            if ($user && $credit instanceof Credit) {
                // Convertir l'ID utilisateur en entier et définir l'ID client
                $credit->setIdClient(intval($user->getId()));
                
            }
        })
            ->add('id_client', null, [
                'disabled' => true, // Le champ est désactivé pour éviter que l'utilisateur puisse le modifier
            ])
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
            ->add('fichesalire', FileType::class, [
                'label' => 'Brochure (PDF file)',
                // unmapped means that this field is not associated to any entity property
                'mapped' => false,
            ])
          ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Credit::class,
        ]);
    }
}
