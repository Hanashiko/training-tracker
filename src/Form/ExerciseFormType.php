<?php

namespace App\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\{
    Exercise,
    MuscleGroup
};
use Symfony\Component\Form\{
    AbstractType,
    FormBuilderInterface
};

class ExerciseFormType extends AbstractType
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
                'group_by' => 
                    fn(MuscleGroup $muscle) => $muscle->getCategory()
                        ? $muscle->getCategory()->getName() 
                        : 'Uncategoriized',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Exercise::class,
        ]);
    }
}
