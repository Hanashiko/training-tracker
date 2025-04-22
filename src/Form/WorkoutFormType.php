<?php

namespace App\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\{
    User,
    Workout
};
use Symfony\Component\Form\Extension\Core\Type\{
    CollectionType,
    TextareaType
};
use Symfony\Component\Form\{
    AbstractType,
    FormBuilderInterface
};

class WorkoutFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', null, [
                'widget' => 'single_text',
                'label' => 'Дата тренування',
                'input' => 'datetime_immutable',
            ])
            ->add('notes', TextareaType::class, [
                'label' => 'Нотатки',
                'required' => false,
            ])
            ->add('workoutExercises', CollectionType::class, [
                'entry_type' => WorkoutExerciseFormType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Workout::class,
        ]);
    }
}
