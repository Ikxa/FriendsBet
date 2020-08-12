<?php

namespace App\Form\Security;

use App\Entity\Security\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class SignupType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'username',
                TextType::class,
                [
                    'label' => false,
                    'attr' => [
                        'placeholder' => 'John Doe',
                    ]
                ]
            )
            ->add(
                'email',
                EmailType::class,
                [
                    'label' => false,
                    'attr' => [
                        'placeholder' => 'john.doe@gmail.com',
                    ]
                ]
            )
            ->add(
                'password',
                PasswordType::class,
                [
                    'label' => false,
                    'attr' => [
                        'placeholder' => 'Saisir un mot de passe',
                    ]
                ]
            )
            ->add(
                'phone',
                TextType::class,
                [
                    'label' => false,
                    'attr' => [
                        'placeholder' => '0630434874',
                    ]
                ]
            )
            /*->add(
                'submit',
                SubmitType::class,
                [
                    'label' => 'form.submit'
                ]
            )*/;
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => User::class,
                'translation_domain' => 'forms'
            ]
        );
    }
}
