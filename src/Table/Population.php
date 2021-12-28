<?php

namespace App\Table;

use PSX\Sql\Condition;
use PSX\Sql\Sql;
use PSX\Sql\TableAbstract;

class Population extends TableAbstract
{
    public function getName(): string
    {
        return 'population';
    }

    public function getColumns(): array
    {
        return array(
            'id'          => self::TYPE_INT | 10 | self::AUTO_INCREMENT | self::PRIMARY_KEY,
            'place'       => self::TYPE_INT | 10,
            'region'      => self::TYPE_VARCHAR | 64,
            'population'  => self::TYPE_INT | 10,
            'users'       => self::TYPE_INT | 10,
            'world_users' => self::TYPE_FLOAT,
            'insert_date' => self::TYPE_DATETIME,
        );
    }

    public function getCollection(?int $startIndex = null, ?int $count = null, ?string $search = null)
    {
        if (empty($startIndex) || $startIndex < 0) {
            $startIndex = 0;
        }

        if (empty($count) || $count < 1 || $count > 1024) {
            $count = 16;
        }

        $condition = new Condition();

        if (!empty($search)) {
            $condition->like('region', '%' . $search . '%');
        }

        $definition = [
            'totalResults' => $this->getCount($condition),
            'startIndex' => $startIndex,
            'itemsPerPage' => $count,
            'entry' => $this->doCollection([$this, 'findAll'], [$condition, $startIndex, $count, null, Sql::SORT_DESC], [
                'id' => $this->fieldInteger('id'),
                'place' => $this->fieldInteger('place'),
                'region' => 'region',
                'population' => $this->fieldInteger('population'),
                'users' => $this->fieldInteger('users'),
                'worldUsers' => $this->fieldNumber('world_users'),
                'datetime' => $this->fieldDateTime('insert_date'),
            ]),
        ];

        return $this->build($definition);
    }

    public function getEntity(int $id)
    {
        $definition = $this->doEntity([$this, 'find'], [$id], [
            'id' => $this->fieldInteger('id'),
            'place' => $this->fieldInteger('place'),
            'region' => 'region',
            'population' => $this->fieldInteger('population'),
            'users' => $this->fieldInteger('users'),
            'worldUsers' => $this->fieldNumber('world_users'),
            'datetime' => $this->fieldDateTime('insert_date'),
        ]);

        return $this->build($definition);
    }
}
