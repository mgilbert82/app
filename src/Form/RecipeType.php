<?php

namespace App\Form;

use App\Entity\Recipe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre de la fiche recette',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Renseigner le titre de la fiche recette',
                    'class' => 'form-control mb-4',
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description de la fiche recette',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Renseigner la description de la fiche recette',
                    'class' => 'form-control mb-4',
                    'rows' => 5,
                ]
            ])
            ->add('instruction', TextareaType::class, [
                'label' => 'Etape de préparation de la fiche recette',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Renseigner les étapes de préparation',
                    'class' => 'form-control mb-4',
                    'rows' => 10,
                ]
            ])
            ->add('cooktime', TimeType::class, [
                'label' => 'Temps de préparation de la recette',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Renseigner le temps de préparation de la recette',
                    'class' => 'form-select mb-4',
                ]
            ])
            ->add('baketime', TimeType::class, [
                'label' => 'Temps de cuisson de la recette',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Renseigner le temps de cuisson de la recette',
                    'class' => 'form-select mb-4',
                ]
            ])
            ->add('ingredient', TextareaType::class, [
                'label' => 'Liste des ingrédients de la fiche recette',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Renseigner les ingrédients de la fiche recette',
                    'class' => 'form-control mb-4',
                    'rows' => 8
                ]
            ])
            ->add('illustration', FileType::class, [
                'label' => 'Importer une image illustrant la recette',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'class' => 'input-group mb-4',
                ],
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpg',
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Veuillez importer une image valide',
                    ])
                ],
            ])
            ->add('isforpatient', CheckboxType::class, [
                'label' => 'Cette recette est réservé au patient',
                'attr' => [
                    'class' => 'input-group-text mb-4',
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer la fiche recette',
                'attr' => [
                    'class' => 'btn btn-block btn-info mt-5 mb-5'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}
