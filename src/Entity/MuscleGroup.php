<?php

namespace App\Entity;

use App\Repository\MuscleGroupRepository;
use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\{
    ArrayCollection,
    Collection
};

#[ORM\Entity(repositoryClass: MuscleGroupRepository::class)]
class MuscleGroup
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'muscleGroups')]
    #[ORM\JoinColumn(nullable: false)]
    private ?MuscleGroupCategory $category = null;

    /**
     * @var Collection<int, Exercise>
     */
    // #[ORM\ManyToMany(targetEntity: Exercise::class, inversedBy: 'muscleGroups')]
    #[ORM\ManyToMany(targetEntity: Exercise::class, mappedBy: 'muscleGroups')]
    private Collection $exercises;

    public function __construct()
    {
        $this->exercises = new ArrayCollection();
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
    /**
     * @return Collection<int, Exercise>
     */
    public function getExercises(): Collection
    {
        return $this->exercises;
    }

    public function addExercise(Exercise $exercise): static
    {
        if (!$this->exercises->contains($exercise)) {
            $this->exercises->add($exercise);
        }

        return $this;
    }

    public function removeExercise(Exercise $exercise): static
    {
        $this->exercises->removeElement($exercise);

        return $this;
    }

    public function getCategory(): ?MuscleGroupCategory
    {
        return $this->category;
    }

    public function setCategory(?MuscleGroupCategory $category): static
    {
        $this->category = $category;

        return $this;
    }
}
