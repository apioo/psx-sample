<?php

namespace App\Dependency;

use App\Service;
use App\Table;
use PSX\Framework\Dependency\DefaultContainer;

class Container extends DefaultContainer
{
    public function getPopulationService(): Service\Population
    {
        return new Service\Population(
            $this->get('table_manager')->getTable(Table\Population::class)
        );
    }
}
