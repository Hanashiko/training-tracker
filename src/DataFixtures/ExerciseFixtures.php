<?php

namespace App\DataFixtures;

use App\Entity\Exercise;
use App\Repository\MuscleGroupRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ExerciseFixtures extends Fixture implements DependentFixtureInterface
{
    private MuscleGroupRepository $muscleGroupRepository;

    public function __construct(MuscleGroupRepository $muscleGroupRepository)
    {
        $this->muscleGroupRepository = $muscleGroupRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $exercisesData = [
            ['Bench Press', ['Pectoralis Major', 'Triceps Brachii', 'Anterior Deltoid']],
            ['Deadlift', ['Latissimus Dorsi', 'Erector Spinae', 'Gluteus Maximus', 'Biceps Femoris']],
            ['Squat', ['Rectus Femoris', 'Gluteus Maximus', 'Biceps Femoris']],
            ['Pull-Up', ['Latissimus Dorsi', 'Biceps Brachii', 'Rhomboids']],
            ['Overhead Press', ['Anterior Deltoid', 'Triceps Brachii']],
            ['Bicep Curl', ['Biceps Brachii', 'Brachialis']],
            ['Triceps Dips', ['Triceps Brachii', 'Anterior Deltoid', 'Pectoralis Major']],
            ['Leg Press', ['Vastus Lateralis', 'Gluteus Maximus', 'Semitendinosus']],
            ['Calf Raise', ['Gastrocnemius', 'Soleus']],
            ['Plank', ['Rectus Abdominis', 'Obliques', 'Transverse Abdominis']]
        ];

        foreach ($exercisesData as [$exerciseName, $muscleNames]) {
            $exercise = new Exercise();
            $exercise->setName($exerciseName);
            
            foreach ($muscleNames as $muscleName) {
                $muscleGroup = $this->muscleGroupRepository->findOneBy(['name' => $muscleName]);
                // if (!$muscleGroup) {
                //     echo "Muscle group not found: " . $muscleName . "\n";
                //     continue;
                // }
                // $exercise->addMuscleGroup($muscleGroup);
                if ($muscleGroup) {
                    $exercise->addMuscleGroup($muscleGroup);
                }
            }
            
            $manager->persist($exercise);
        }

        $manager->flush();
    }
    public function getDependencies(): array
    {
        return [
            MuscleGroupFixtures::class,
        ];
    }
}
