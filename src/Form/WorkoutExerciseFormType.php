<?php

namespace App\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\{
    Exercise,
    Workout,
    WorkoutExercise
};
use Symfony\Component\Form\Extension\Core\Type\{
    IntegerType as IntegerType,
    NumberType
};
use Symfony\Component\Form\{
    AbstractType,
    FormBuilderInterface
};

class WorkoutExerciseFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    { 
        $builder
            ->add('exercise', EntityType::class, [
                'class' => Exercise::class,
                'choice_label' => 'name',
                'placeholder' => 'Оберіть вправу',
            ])
            ->add('sets', IntegerType::class, [
                'label' => 'Підходи',
                'attr' => ['min' => 1],
            ])
            ->add('reps', IntegerType::class, [
                'label' => 'Повторення',
                'attr' => ['min' => 1],
            ])
            ->add('weight', NumberType::class, [
                'label' => 'Вага (кг)',
                'required' => false,
                'html5' => true,
                'attr' => ['step' => '0.1']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => WorkoutExercise::class,
            // 'exercises' => [],
        ]);
    }
}
