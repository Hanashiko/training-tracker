<?php

namespace App\DataFixtures;

use App\Entity\Exercise;
use App\Repository\MuscleGroupCategoryRepository;
use App\Repository\MuscleGroupRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ExerciseFixtures extends Fixture
{
    private MuscleGroupRepository $muscleGroupRepository;

    public function __construct(MuscleGroupRepository $muscleGroupRepository)
    {
        $this->muscleGroupRepository = $muscleGroupRepository;
    }
    public function load(ObjectManager $manager): void
    {
        $exercisesData = [
            ['Bench Press', ['Pectoralis Major', 'Triceps Brachii']],
            ['Deadlift', ['Erector Spinae', 'Gluteus Maximus', 'Hamstrings']],
            ['Squat', ['Quadriceps', 'Gluteus Maximus', 'Hamstrings']],
            ['Pull-Up', ['Latissimus Dorsi', 'Biceps Brachii', 'Trapezius']],
            ['Overhead Press', ['Anterior Deltoid', 'Triceps Brachii']],
            ['Bicep Curl', ['Biceps Brachii', 'Brachialis']],
            ['Barbell Row', ['Latissimus Dorsi', 'Rhomboids', 'Biceps Brachii']],
            ['Leg Press', ['Quadriceps', 'Gluteus Maximus', 'Hamstrings']],
            ['Calf Raise', ['Gastrocnemius', 'Soleus']],
            ['Dumbbell Curl', ['Biceps Brachii', 'Brachialis']],
            ['Triceps Dip', ['Triceps Brachii', 'Anterior Deltoid']],
            ['Leg Press', ['Quadriceps', 'Gluteus Maximus', 'Hamstrings']],
            ['Plank', ['Rectus Abdominis', 'Transverse Abdominis', 'Serratus Anterior']],
        ];

        foreach ($exercisesData as [$exerciseName, $muscleNames]) {
            $exercise = new Exercise();
            $exercise->setName($exerciseName);

            foreach ($muscleNames as $muscleName) {
                $muscleGroup = $this->muscleGroupRepository->findOneBy(['name' => $muscleName]);
                if ($muscleGroup) {
                    $exercise->addMuscleGroup($muscleGroup);
                }
            }
            $manager->persist($exercise);
        }
        $manager->flush();
    }
}