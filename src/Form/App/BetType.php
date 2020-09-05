<?php

namespace App\Form\App;

use App\Entity\App\Bet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'scoreFirstTeam',
                IntegerType::class,
                [
                    'label' => 'Score de l\'équipe 1',
                ]
            )
            ->add(
                'scoreSecondTeam',
                IntegerType::class,
                [
                    'label' => 'Score de l\'équipe 2',
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Bet::class,
        ]);
    }
}
