<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'fullName',
                TextType::class,
                [
                    'attr' => [
                        'class' => 'form-control',
                        'minlenght' => '2',
                        'maxlenght' => '50'
                    ],
                    'label' => 'Nom / Prénom',
                    'label_attr' => [
                        'class' => 'form-label mt-4'
                    ],
                    'constraints' => [
                        new Assert\NotBlank(),
                        new Assert\Length(['min' => 2, 'max' => 50])
                    ]
                ]
            )

            ->add(
                'pseudo',
                TextType::class,
                [
                    'attr' => [
                        'class' => 'form-control',
                        'minlenght' => '2',
                        'maxlenght' => '50'
                    ],
                    'required' => false,
                    'label' => 'Pseudo ',
                    'label_attr' => [
                        'class' => 'form-label mt-4'
                    ],
                    'constraints' => [
                        new Assert\Length(['min' => 2, 'max' => 50])
                    ]
                ]
            )

            ->add(
                'plainPassword',
                PasswordType::class,
                [
                    'label' => 'Mot de passe',
                    'label_attr' => [
                        'class' => 'form-label mt-4'
                    ],
                    'attr' => [
                        'class' => 'form-control'
                    ]
                ]
            )

            ->add(
                'submit',
                SubmitType::class,
                [
                    'attr' => [
                        'class' => 'btn btn-primary mt-4'
                    ],
                    'label' => 'Mettre à jour !'
                ]
            );;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
