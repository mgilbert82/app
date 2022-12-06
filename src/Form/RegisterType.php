<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname', TextType::class, [
                'label' => 'Nom du patient',
                'attr' => [
                    'placeholder' => 'Renseigner le nom du patient',
                    'class' => 'form-control mb-4',
                ]
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom du patient',
                'attr' => [
                    'placeholder' => 'Renseigner le prénom du patient',
                    'class' => 'form-control mb-4',
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email du patient',
                'attr' => [
                    'placeholder' => "Renseigner l'email du patient",
                    'class' => 'form-control mb-4',
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe et la confirmation doivent être identique',
                'label' => 'Mot de passe du patient',
                'required' => true,
                'first_options' => [
                    'label' => 'Mot de passe du patient',
                    'attr' => [
                        'placeholder' => 'Renseigner le mot de passe du patient',
                        'class' => 'form-control mb-4',
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirmer le mot de passe du patient',
                    'attr' => [
                        'placeholder' => 'Renseigner le mot de passe du patient',
                        'class' => 'form-control mb-4',
                    ]
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer un nouveau compte patient',
                'attr' => [
                    'class' => 'btn btn-block btn-info mt-5'
                ]
            ])
            //->add('roles')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
