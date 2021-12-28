<?php

namespace App\Model;

use PSX\Schema\Attribute\Description;

#[Description('Collection result')]
class Collection
{
    private ?int $totalResults;

    /**
     * @var array<Population>
     */
    private ?array $entry;

    public function __construct(?int $totalResults = null, ?array $entry = null)
    {
        $this->totalResults = $totalResults;
        $this->entry = $entry;
    }

    public function getTotalResults(): ?int
    {
        return $this->totalResults;
    }

    public function setTotalResults(int $totalResults): void
    {
        $this->totalResults = $totalResults;
    }

    public function getEntry(): ?array
    {
        return $this->entry;
    }

    public function setEntry(array $entry): void
    {
        $this->entry = $entry;
    }
}
