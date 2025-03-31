<?php

namespace App\DataFixtures;

use App\Entity\MuscleGroup;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MuscleGroupFixtures extends Fixture
{
    public function load(ObjectManager $objectManager): void
    {
        $muscleHierarchy = [
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
        foreach ($muscleHierarchy as $category => $subGroups) {
            $categoryEntity = new MuscleGroup();
            $categoryEntity->setName($category);
            $objectManager->persist($categoryEntity);

            foreach ($subGroups as $subGroup) {
                $subGroupEntity = new MuscleGroup();
                $subGroupEntity->setName($subGroup);
                $subGroupEntity->setParent($categoryEntity);
                $objectManager->persist($subGroupEntity);
            }
        }
        $objectManager->flush();
    }
}