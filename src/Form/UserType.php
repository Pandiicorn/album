<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Validator\Constraints as Assert;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'attr' => [
                    'minlength' => 2,
                    'maxlength' => 55
                ],
                'label' => 'Firstname',
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 55])
                ]
            ])

            ->add('lastname', TextType::class, [
                'attr' => [
                    'minlength' => 2,
                    'maxlength' => 55
                ],
                'label' => 'Lastname',
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 55])
                ]
            ])

            ->add('email', EmailType::class, [
                'attr' => [
                    'minlength' => 2,
                    'maxlength' => 180
                ],
                'label' => 'Mail Address',
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Email(),
                    new Assert\Length(['min' => 2, 'max' => 180])
                ]
            ])

            ->add('plainPassword', PasswordType::class, [
                'label' => 'Enter your password to update your profil'
            ])

            ->add('submit', SubmitType::class, [
                'label' => 'Update profile'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
