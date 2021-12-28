<?php

namespace App\Model;

use PSX\Schema\Attribute\Description;
use PSX\Schema\Attribute\Maximum;
use PSX\Schema\Attribute\MaxLength;
use PSX\Schema\Attribute\Minimum;
use PSX\Schema\Attribute\MinLength;
use PSX\Schema\Attribute\Pattern;
use PSX\Schema\Attribute\Required;

#[Description('Represents an internet population entity')]
#[Required(["place", "region", "population", "users", "worldUsers"])]
class Population
{
    #[Description('Unique id for each entry')]
    private ?int $id = null;

    #[Minimum(1)]
    #[Maximum(64)]
    #[Description('Position in the top list')]
    private ?int $place = null;

    #[MinLength(3)]
    #[MaxLength(64)]
    #[Pattern('[A-z]+')]
    #[Description('Name of the region')]
    private ?string $region = null;

    #[Description('Complete number of population')]
    private ?int $population = null;

    #[Description('Number of internet users')]
    private ?int $users = null;

    #[Description('Percentage users of the world')]
    private ?float $worldUsers = null;

    #[Description('Date when the entity was created')]
    private ?\DateTime $datetime = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getPlace(): ?int
    {
        return $this->place;
    }

    public function setPlace(?int $place): void
    {
        $this->place = $place;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(?string $region): void
    {
        $this->region = $region;
    }

    public function getPopulation(): ?int
    {
        return $this->population;
    }

    public function setPopulation(?int $population): void
    {
        $this->population = $population;
    }

    public function getUsers(): ?int
    {
        return $this->users;
    }

    public function setUsers(?int $users): void
    {
        $this->users = $users;
    }

    public function getWorldUsers(): ?float
    {
        return $this->worldUsers;
    }

    public function setWorldUsers(?float $worldUsers): void
    {
        $this->worldUsers = $worldUsers;
    }

    public function getDatetime(): ?\DateTime
    {
        return $this->datetime;
    }

    public function setDatetime(?\DateTime $datetime): void
    {
        $this->datetime = $datetime;
    }
}
