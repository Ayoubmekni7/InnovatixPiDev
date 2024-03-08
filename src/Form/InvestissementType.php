<?php

namespace App\Form;

use App\Entity\Investissement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;

class InvestissementType extends AbstractType
{
    private $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', ChoiceType::class, [
                'choices' => array_flip($this->getProjectNames()), // flip the array to use names as keys
                'attr' => ['class' => 'form-control', 'id' => 'nom_investissement'],
            ])
            ->add('montant')
            ->add('dateInvestissement')
            ->add('description')
            ->add('typeInvestissement')
            ->add('duree')
            ->add('tauxRendement')
            ->add('statut')
            ->add('createdAt')
            ->add('updatedAt')
        ;
        
    }
    
    private function getProjectNames()
    {
        $projectNames = [];
        $projects = $this->entityManager->getRepository(Project::class)->findAll();
        foreach ($projects as $project) {
            $projectNames[$project->getId()] = $project->getNomProjet();
        }
        return $projectNames;
    }
    
    
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Investissement::class,
        ]);
    }
}
