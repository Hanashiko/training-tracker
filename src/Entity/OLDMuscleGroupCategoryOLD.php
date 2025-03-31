<?php

namespace App\Entity;

use App\Repository\MuscleGroupCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MuscleGroupCategoryRepository::class)]
class MuscleGroupCategoryOLD
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    // #[ORM\ManyToOne(inversedBy: 'muscleGroupCategories')]
    // private ?MuscleGroup $muscleGroups = null;
    #[ORM\OneToMany(mappedBy: 'category', targetEntity: MuscleGroup::class, cascade: ['persist','remove'])]
    private MuscleGroup $muscleGroups;
    
    // public function __construct()
    // {
    //     $this->muscleGroups = new ArrayCollection();
    // }

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

    public function getMuscleGroups(): MuscleGroup
    {
        return $this->muscleGroups;
    }

    public function setMuscleGroups(?MuscleGroup $muscleGroups): static
    {
        $this->muscleGroups = $muscleGroups;

        return $this;
    }
}
