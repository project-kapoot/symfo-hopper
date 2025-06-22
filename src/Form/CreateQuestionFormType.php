<?php

namespace App\Form;

use App\Entity\Question;
use App\Entity\Quizz;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\AnswerType; 

class CreateQuestionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        
            ->add('content', TextareaType::class, [
                'label' => 'Question',
                'attr' => [
                    'rows' => 4,
                    'placeholder' => 'Saisissez votre question...'
                ]
            ])
            ->add('explanation', TextareaType::class, [
                'label' => 'Explication',
                'attr' => [
                    'rows' => 3,
                    'placeholder' => 'Explication de la réponse...'
                ]
            ])
            ->add('timeMax', ChoiceType::class, [
                'label' => 'Temps maximum',
                'choices' => [
                    '10 secondes' => 'PT10S',
                    '20 secondes' => 'PT20S',
                    '30 secondes' => 'PT30S',
                    '40 secondes' => 'PT40S',
                    '50 secondes' => 'PT50S',
                    '1 minute' => 'PT1M',
                    '1 minute 30 secondes' => 'PT1M30S',
                ],
                'placeholder' => 'Sélectionner le temps', // Ajout du placeholder
            ])
            ->add('scoreMin', IntegerType::class, [
                'label' => 'Score minimum',
                'attr' => ['min' => 0]
            ])
            ->add('scoreMax', IntegerType::class, [
                'label' => 'Score maximum',
                'attr' => ['min' => 0]
            ])
            ->add('quizz', EntityType::class, [
                'class' => Quizz::class,
                    'choice_label' => 'name', 
                    'label' => 'Quiz associé',
                    'placeholder' => 'Choisir un quiz...'
                ])
                  // ✅ ESSENTIEL : Le CollectionType pour les answers
               ->add('answers', CollectionType::class, [
                'entry_type' => AnswerType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => 'Réponses',
                'entry_options' => [
                    'label' => true,
                ],
            ]);
           
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}