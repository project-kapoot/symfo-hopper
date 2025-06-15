<?php

namespace App\Form;

use App\Entity\Quizz;
// use App\Entity\User;
// use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InfoGeneralesFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label_format' => 'Nom du quizz',
                'attr' => [
                    'placeholder' => 'ex: Quizz CSS'
                ],
                'row_attr' => ['class' => 'mb-3'],
            ])
            ->add('category', TextType::class, [
                'label_format' => 'Catégorie du quizz',
                'attr' => [
                    'placeholder' => 'ex: Les bases du CSS'
                ],
                'row_attr' => ['class' => 'mb-3'],
            ])
            ->add('logo', FileType::class, [
                'label_format' => 'Logo du quizz',
                'row_attr' => ['class' => 'mb-3'],
            ])
            ->add('description', TextareaType::class, [
                'label_format' => 'Description du quizz',
                'attr' => [
                    'placeholder' => 'ex: Quizz contenant des questions basics sur le CSS, flexbox, grid...',
                    'rows' => "5"
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Quizz::class,
        ]);
    }
}
