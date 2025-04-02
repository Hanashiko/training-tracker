<?php

namespace App\Form;

use App\Entity\Exercise;
use App\Entity\Workout;
use App\Entity\WorkoutExercise;
use Doctrine\DBAL\Types\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WorkoutExerciseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('exercise', EntityType::class, [
                'class' => Exercise::class,
                'choices' => $options['exercises'],
                'label' => 'Вправа',
                'placeholder' => 'Оберіть вправу',
            ])
            ->add('sets', IntegerType::class, [
                'label' => 'Підходи',
            ])
            ->add('reps', IntegerType::class, [
                'label' => 'Повторення',
            ])
            ->add('weight', NumberType::class, [
                'label' => 'Вага (кг)',
                'required' => false,
            ])
            // ->add('workout', EntityType::class, [
            //     'class' => Workout::class,
            //     'choice_label' => 'id',
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => WorkoutExercise::class,
            'exercises' => [],
        ]);
    }
}
