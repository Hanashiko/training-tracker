<?php

namespace App\Entity;

use App\Repository\MuscleGroupRepository;
use App\Entity\MuscleGroupCategory;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MuscleGroupRepository::class)]
class MuscleGroupOLD
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    // #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'subGroups')]
    // #[ORM\JoinColumn(onDelete: 'CASCADE')]
    // private ?self $parent = null;

    // #[ORM\OneToMany(mappedBy: 'parent', targetEntity: self::class)]
    // private Collection $subGroups;
    #[ORM\ManyToOne(targetEntity: MuscleGroupCategory::class, inversedBy: 'muscleGroups')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private MuscleGroupCategory $category;

    /**
     * @var Collection<int, Exercise>
     */
    // #[ORM\ManyToMany(targetEntity: Exercise::class, inversedBy: 'muscleGroups')]
    #[ORM\ManyToMany(targetEntity: Exercise::class, mappedBy: 'muscleGroups')]
    private Collection $exercises;

    // /**
    //  * @var Collection<int, MuscleGroupCategory>
    //  */
    // #[ORM\OneToMany(targetEntity: MuscleGroupCategory::class, mappedBy: 'muscleGroups')]
    // private Collection $muscleGroupCategories;

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

    // public function getParent(): ?self{
    //     return $this->parent;
    // }
    // public function setParent(?self $parent): static{
    //     $this->parent = $parent;
    //     return $this;
    // }

    // /**
    //  * @return Collection<int, MuscleGroup>
    //  */
    // public function getSubGroups(): Collection{
    //     return $this->subGroups;
    // }
    // public function addSubGroup(MuscleGroup $subGroup): static{
    //     if(!$this->subGroups->contains($subGroup)){
    //         $this->subGroups->add($subGroup);
    //     }
    //     return $this;
    // }
    // public function removeSubGroup(MuscleGroup $subGroup): static{
    //     $this->subGroups->removeElement($subGroup);
    //     return $this;
    // }

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

    /**
     * @return MuscleGroupCategory<int, MuscleGroupCategory>
     */
    public function getCategories(): MuscleGroupCategory
    {
        return $this->category;
    }

    public function setCategory(MuscleGroupCategory $category): static
    {
        // if (!$this->muscleGroupCategories->contains($muscleGroupCategory)) {
        //     $this->muscleGroupCategories->add($muscleGroupCategory);
        //     $muscleGroupCategory->setMuscleGroups($this);
        // }
        $this->category = $category;

        return $this;
    }

    // public function removeCategory(MuscleGroupCategory $category): static
    // {
        // if ($this->muscleGroupCategories->removeElement($muscleGroupCategory)) {
        //     // set the owning side to null (unless already changed)
        //     if ($muscleGroupCategory->getMuscleGroups() === $this) {
        //         $muscleGroupCategory->setMuscleGroups(null);
        //     }
        // }
        // $this->category->removeElement($category);

    //     if ($this->category->removeElement($category)) {
    //         if ($category->getMuscleGroups() === $this) {
    //             $category->setMuscleGroups(null);
    //         }
    //     }

        
    //     return $this;
    // }
}
