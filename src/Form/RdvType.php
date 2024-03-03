<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Entity\Credit;
use App\Entity\Rdv;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Repository\CreditRepository;
use Symfony\Component\Security\Core\Security;

class RdvType extends AbstractType
{
    private $creditRepository;
    private $security;


    public function __construct(CreditRepository $creditRepository,Security $security)
    {
        $this->creditRepository = $creditRepository;
        $this->security = $security;

    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $user = $this->security->getUser();

        $builder
        ->add('idclient', null, [
            'label' => 'identifiant', // Changer le nom du label ici
            // Autres options de champ
        ])
            ->add('daterdv')
            ->add('heure')
            ->add('methode', ChoiceType::class, [
                'choices' => [
                    'Présentiel' => 'présentiel',
                    'En ligne' => 'en ligne',
                ],
                'expanded' => false,
                'multiple' => false,
            ])
            ->add('employename')
            ->add('credit', EntityType::class, [
                'class' => Credit::class,
                'choice_label' => function (Credit $credit) {
                    return $credit->getId();
                },
                'choices' => $user->getCredit(), // Supposons que getCredit() renvoie les crédits disponibles pour l'utilisateur connecté
                'placeholder' => 'Sélectionnez un crédit',
            ]);
        
    }

    private function getAvailableClients(): array
    {
        $credits = $this->creditRepository->findAll();
        $clients = [];
        foreach ($credits as $credit) {
            $clients[$credit->getIdClient()] = $credit;
        }
        return $clients;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Rdv::class,
        ]);
    }
}
