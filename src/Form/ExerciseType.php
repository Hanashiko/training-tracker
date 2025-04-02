<?php

namespace App\Form;

use App\Entity\Exercise;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\MuscleGroup;

class ExerciseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('muscleGroups', EntityType::class, [
                'class' => MuscleGroup::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'group_by' => fn(MuscleGroup $muscle) => $muscle->getCategory() ? $muscle->getCategory()->getName() : 'Uncategoriized',
            ])
            // ->add('muscleGroups', EntityType::class, [
            //     'class' => MuscleGroup::class,
            //     'choice_label' => function (MuscleGroup $muscleGroup) {
            //         return $muscleGroup->getParent()
            //         ? '- ' . $muscleGroup->getName()
            //         : $muscleGroup->getName();
            //     },
            //     'group_by' => function(MuscleGroup $muscleGroup) {
            //         return $muscleGroup->getParent()
            //         ?$muscleGroup->getParent()->getName()
            //         : null;
            //     },
            //     'multiple' => true,
            //     'expanded' => true,
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Exercise::class,
        ]);
    }
}
