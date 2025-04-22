<?php

namespace App\Entity;

use App\Repository\MuscleGroupCategoryRepository;
use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\{
    ArrayCollection,
    Collection
};

#[ORM\Entity(repositoryClass: MuscleGroupCategoryRepository::class)]
class MuscleGroupCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, MuscleGroup>
     */
    #[ORM\OneToMany(targetEntity: MuscleGroup::class, mappedBy: 'category', orphanRemoval: true)]
    private Collection $muscleGroups;

    public function __construct()
    {
        $this->muscleGroups = new ArrayCollection();
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
            $muscleGroup->setCategory($this);
        }

        return $this;
    }

    public function removeMuscleGroup(MuscleGroup $muscleGroup): static
    {
        if ($this->muscleGroups->removeElement($muscleGroup)) {
            // set the owning side to null (unless already changed)
            if ($muscleGroup->getCategory() === $this) {
                $muscleGroup->setCategory(null);
            }
        }

        return $this;
    }
}
