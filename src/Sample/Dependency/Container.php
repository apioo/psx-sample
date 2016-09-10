<?php

namespace Sample\Dependency;

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use PSX\Framework\Dependency\DefaultContainer;
use Sample\Service;

class Container extends DefaultContainer
{
    /**
     * @return \Sample\Service\Population
     */
    public function getPopulationService()
    {
        return new Service\Population(
            $this->get('table_manager')->getTable('Sample\Table\Population')
        );
    }
}
