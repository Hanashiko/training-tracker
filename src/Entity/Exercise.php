<?php

namespace App\Entity;

use App\Repository\ExerciseRepository;
use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\{
    ArrayCollection,
    Collection
};

#[ORM\Entity(repositoryClass: ExerciseRepository::class)]
class Exercise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    /**
     * @var Collection<int, WorkoutExercise>
     */
    #[ORM\OneToMany(targetEntity: WorkoutExercise::class, mappedBy: 'exercise')]
    private Collection $workoutExercises;

    /**
     * @var Collection<int, MuscleGroup>
     */
    // #[ORM\ManyToMany(targetEntity: MuscleGroup::class, mappedBy: 'exercises')]
    #[ORM\ManyToMany(targetEntity: MuscleGroup::class, inversedBy: 'exercises')]
    #[ORM\JoinTable(name: 'exercise_muscle_group')]
    private Collection $muscleGroups;

    public function __construct()
    {
        $this->workoutExercises = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->muscleGroups = new ArrayCollection();
    }
    
    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @return Collection<int, WorkoutExercise>
     */
    public function getWorkoutExercises(): Collection
    {
        return $this->workoutExercises;
    }

    public function addWorkoutExercise(WorkoutExercise $workoutExercise): static
    {
        if (!$this->workoutExercises->contains($workoutExercise)) {
            $this->workoutExercises->add($workoutExercise);
            $workoutExercise->setExercise($this);
        }

        return $this;
    }

    public function removeWorkoutExercise(WorkoutExercise $workoutExercise): static
    {
        if ($this->workoutExercises->removeElement($workoutExercise)) {
            if ($workoutExercise->getExercise() === $this) {
                $workoutExercise->setExercise(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MuscleGroup>
     */
    public function getMuscleGroups(): Collection
    {
        return $this->muscleGroups;
    }

    public function addMuscleGroup(MuscleGroup $muscleGroup): static
    {
        if (!$this->muscleGroups->contains($muscleGroup)) {
            $this->muscleGroups->add($muscleGroup);
            $muscleGroup->addExercise($this);
        }

        return $this;
    }

    public function removeMuscleGroup(MuscleGroup $muscleGroup): static
    {
        if ($this->muscleGroups->removeElement($muscleGroup)) {
            $muscleGroup->removeExercise($this);
        }

        return $this;
    }
}
