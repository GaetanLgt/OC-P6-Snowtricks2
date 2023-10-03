<?php

namespace App\Form;

use App\Entity\Media;
use App\Entity\Trick;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MediaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('url', TextType::class , 
            [
                'label' => 'Url de la vidéo',
                'attr' => [
                    'placeholder' => 'Url de la vidéo'
                ],
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir une url de vidéo',
                    ]),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'L\'url de la vidéo doit contenir au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 255,
                    ]),
                ],
            ])
            ->add('type', TextType::class ,
            [
                'label' => 'Type de la vidéo',
                'attr' => [
                    'placeholder' => 'Type de la vidéo'
                ],
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un type de vidéo',
                    ]),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Le type de la vidéo doit contenir au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 255,
                    ]),
                ],
            ])
            ->add('Trick', EntityType::class, [
                'class' => Trick::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('t')
                        ->orderBy('t.name', 'ASC');
                },
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Media::class,
        ]);
    }
}
