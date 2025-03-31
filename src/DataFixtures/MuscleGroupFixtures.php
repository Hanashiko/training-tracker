<?php

namespace App\DataFixtures;

use App\Entity\MuscleGroup;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MuscleGroupFixtures extends Fixture
{
    public function load(ObjectManager $objectManager): void
    {
        $muscles = [
            'Chest' => ['Pectoralis Major', 'Pectoralis Minor'],
            'Back' => ['Latissimus Dorsi', 'Trapezius', 'Rhomboids', 'Erector Spinae', 'Teres Major & Minor', 'Infraspinatus'],
            'Shoulders' => ['Anterior Deltoid', 'Lateral Deltoid', 'Posterior Deltoid'],
            'Arms' => ['Biceps Brachii', 'Brachialis', 'Brachioradialis', 'Triceps Brachii', 'Forearm Flexors & Extensors'],
            'Core' => ['Rectus Abdominis', 'Obliques', 'Transverse Abdominis', 'Serratus Anterior', 'Hip Flexors'],
            'Glutes' => ['Gluteus Maximus', 'Gluteus Medius', 'Gluteus Minimus'],
            'Quadriceps' => ['Rectus Femoris', 'Vastus Lateralis', 'Vastus Medialis', 'Vastus Intermedius'],
            'Hamstrings' => ['Biceps Femoris', 'Semitendinosus', 'Semimembranosus'],
            'Calves' => ['Gastrocnemius', 'Soleus', 'Tibialis Anterior'],
            'Hips & Adductors' => ['Adductor Magnus', 'Abductors'],
            'Stabilizers' => ['Rotator Cuff', 'Pelvic Floor Muscles', 'Multifidus']
        ];
        foreach ($muscles as $categoryName => $muscleNames) {
            $category = new MuscleGroup();
            $category->setName($categoryName);
            $objectManager->persist($category);

            foreach ($muscleNames as $muscleName) {
                $muscle = new MuscleGroup();
                $muscle->setName($muscleName);
                $muscle->setCategory($category);
                $objectManager->persist($muscle);
            }
        }
        $objectManager->flush();
    }
}