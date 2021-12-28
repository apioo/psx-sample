<?php

namespace App\Service;

use App\Model;
use App\Table;
use PSX\Http\Exception as StatusCode;

class Population
{
    protected Table\Population $populationTable;

    public function __construct(Table\Population $populationTable)
    {
        $this->populationTable = $populationTable;
    }

    public function getAll(?int $startIndex = 0, ?int $count = 16): mixed
    {
        return $this->populationTable->getCollection(
            (int) $startIndex,
            (int) $count
        );
    }

    public function get(int $id): mixed
    {
        $population = $this->populationTable->getEntity($id);
        if (empty($population)) {
            throw new StatusCode\NotFoundException('Internet population not found');
        }

        return $population;
    }

    public function create(Model\Population $model)
    {
        $this->populationTable->create([
            'place'       => $model->getPlace(),
            'region'      => $model->getRegion(),
            'population'  => $model->getPopulation(),
            'users'       => $model->getUsers(),
            'world_users' => $model->getWorldUsers(),
            'insert_date' => new \DateTime(),
        ]);
    }

    public function update(int $id, Model\Population $model)
    {
        $population = $this->get($id);
        if (empty($population)) {
            throw new StatusCode\NotFoundException('Internet population not found');
        }

        $this->populationTable->update([
            'id'          => $population['id'],
            'place'       => $model->getPlace(),
            'region'      => $model->getRegion(),
            'population'  => $model->getPopulation(),
            'users'       => $model->getUsers(),
            'world_users' => $model->getWorldUsers(),
        ]);
    }

    public function delete(int $id)
    {
        $population = $this->get($id);
        if (empty($population)) {
            throw new StatusCode\NotFoundException('Internet population not found');
        }

        $this->populationTable->delete([
            'id' => $population['id']
        ]);
    }
}
