<?php

namespace App\Form;

use App\Entity\User;
use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints as Assert;


class RegistrationType extends AbstractType
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
                    new Assert\NotBlank(),
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
                    new Assert\NotBlank(),
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

            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'options' => ['attr' => ['class' => 'input']],
                'first_options' => [
                    'label' => 'Password'
                ],
                'second_options' => [
                    'label' => 'Password Confirm'
                ],
                'invalid_message' => 'Passwords are not the same'
            ])

            ->add('submit', SubmitType::class, [
                'label' => 'Registration'
            ]);

        // ->add('captcha', Recaptcha3Type::class, [
        //     'constraints' => new Recaptcha3(['message' => 'There were problems with your captcha. Please try again or contact with support and provide following code(s): {{ errorCodes }}']),
        //     'action_name' => 'registration',
        // ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
