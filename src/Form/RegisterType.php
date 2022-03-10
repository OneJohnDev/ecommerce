<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class,[
                'label'=> 'Prénom',
                'constraints' => new Length([
                    'min'=> 3,
                    'max'=> 16
                ]),
                'required' => true,
                'attr' =>[
                    'placeholder' => "Ex: John"
                ]
            ])
            ->add('lastname', TextType::class,[
                'label'=> 'Nom',
                'required' => true,
                'attr' =>[
                    'placeholder' => "Ex: One"
                ]
            ])
            ->add('email', EmailType::class,[
                'label'=> 'Votre mail',
                'required' => true,
                'attr' =>[
                    'placeholder' => "Ex: John.one@myshop.com"
                ]
            ])
            ->add('password', RepeatedType::class,[
                'label'=> 'Saissisez un mot de passe',
                'type' => PasswordType::class,
                'invalid_message' => "Le mot de passe doit être identique",
                'required' => true,
                'first_options' => ['label' => "Mot de passe"],
                'second_options' => ['label' => "Confirmez votre mot de passe"]

            ])

            

            ->add('submit', SubmitType::class,[
                'label' => "S'inscrire"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
