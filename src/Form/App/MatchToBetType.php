<?php

namespace App\Form\App;

use App\Entity\App\MatchToBet;
use App\Entity\App\Status;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MatchToBetType extends AbstractType
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'first_team',
                TextType::class,
                [
                    'label' => 'Équipe n°1',
                ]
            )
            ->add(
                'second_team',
                TextType::class,
                [
                    'label' => 'Équipe n°2',
                ]
            )
            ->add(
                'score_first_team',
                TextType::class,
                [
                    'label' => 'Score équipe n°1',
                ]
            )
            ->add(
                'score_second_team',
                TextType::class,
                [
                    'label' => 'Score équipe n°2',
                ]
            )
            ->add(
                'status',
                ChoiceType::class,
                [
                    'label' => 'Status du match',
                    'choices' => $this->getStatus(),
                    'choice_label' => function ($value) {
                        return strtoupper($value);
                    },
                ]
            )
            ->add(
                'winner',
                ChoiceType::class,
                [
                    'label' => 'Gagnant du match',
                    'choices' => [
                        'À déterminer' => 0,
                        'Équipe 1' => 1,
                        'Équipe 2' => 2,
                    ],
                ]
            );
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => MatchToBet::class,
            ]
        );
    }
    
    public function getStatus()
    {
        $status = $this->entityManager
            ->getRepository(Status::class)
            ->findAll();
        $labels = [];
        
        foreach ($status as $st) {
            $labels[] = $st->getLabel();
        }
        
        return $labels;
    }
}
