<?php

namespace App\Form;


use App\Entity\Game;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class GameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [     // Le type est un text
                'attr' => [                      // Attr = les attributs
                    'class' => 'form-control',   // Class bootstrap form-control
                    'minlength' => '2',          // Restriction 
                    'maxlength' => '50'          // Restriction

                ],
                'label' => 'Nom du jeu :',           // Le label
                'label_attr' => [
                    'class' => 'form-label mt-4'  // Class boostrap pour le label
                ],
                'constraints' => [                // Les contraintes
                    new Assert\Length(['min' => 2, 'max' => 50]),  // Minimum 2 et au Maximum 50 caractère
                    new Assert\NotBlank()   // Ne peut pas être vide
                ]
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Description du jeu :',
                'label_attr' => [
                    'class' => 'form-label mt-3'
                ]
            ])

            ->add('price', MoneyType::class, [
                'attr' => [                      // Attr = les attributs
                    'class' => 'form-control'  // Class bootstrap form-control

                ],
                'label' => 'Prix du jeu :',           // Le label
                'label_attr' => [
                    'class' => 'form-label mt-4'  // Class boostrap pour le label
                ],
                'constraints' => [             // Les contraintes
                    new Assert\Positive(),     // Le prix ne peut pas être négative
                    new Assert\LessThan(200)   // Le prix ne dépasse pas 200
                ]
            ])

            ->add('submit', SubmitType::class, [  // Le boutton pour ajouter le jeu
                'attr' => [
                    'class' => 'btn btn-primary mt-4'
                ],
                'label' => 'Enregistrer'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);
    }
}
