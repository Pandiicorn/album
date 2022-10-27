<?php

namespace App\Form;

use App\Entity\Picture;
use App\Entity\Album;
use App\Repository\PictureRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Constraints as Assert;

class AlbumType extends AbstractType
{
    private ?Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'minlength' => 2,
                    'maxlength' => 55
                ],
                'label' => 'Name',
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 55]),
                    new Assert\NotBlank()
                ]
            ])

            ->add('description', TextType::class, [
                'attr' => [
                    'maxlength' => 255,
                ]
            ])

            ->add('pictures', EntityType::class, [
                'class' => Picture::class,
                'query_builder' => function (PictureRepository $repo) {
                    return $repo->createQueryBuilder('p')
                        ->where('p.user = :user')
                        ->orderBy('p.name', 'ASC')
                        ->setParameter('user', $this->security->getUser());
                },

                'choice_label' => function ($picture) {
                    $html = '<img src="' . $picture->getUrl() . '">';
                    return $html;
                },
                'label_html' => true,
                'multiple' => 'true',
                'expanded' => true
            ])

            ->add('submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Album::class,
        ]);
    }
}
