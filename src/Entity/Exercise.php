<?php

namespace App\Entity;

use App\Repository\ExerciseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExerciseRepository::class)]
class Exercise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $muscleGroup = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    /**
     * @var Collection<int, WorkoutExercise>
     */
    #[ORM\OneToMany(targetEntity: WorkoutExercise::class, mappedBy: 'exercise')]
    private Collection $workoutExercises;

    public function __construct()
    {
        $this->workoutExercises = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
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

    public function getMuscleGroup(): ?string
    {
        return $this->muscleGroup;
    }

    public function setMuscleGroup(?string $muscleGroup): static
    {
        $this->muscleGroup = $muscleGroup;

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
            // set the owning side to null (unless already changed)
            if ($workoutExercise->getExercise() === $this) {
                $workoutExercise->setExercise(null);
            }
        }

        return $this;
    }
}
