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

class RdvType extends AbstractType
{
    private $creditRepository;

    public function __construct(CreditRepository $creditRepository)
    {
        $this->creditRepository = $creditRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('idclient')
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
                    return $credit->getIdClient();
                },
                'choices' => $this->getAvailableClients(),
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
