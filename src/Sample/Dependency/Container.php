<?php

namespace Sample\Dependency;

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use PSX\Framework\Dependency\DefaultContainer;
use Sample\Service;

class Container extends DefaultContainer
{
    /**
     * @return \Doctrine\DBAL\Connection
     */
    public function getConnection()
    {
        $config = new Configuration();
        $params = array(
            'user'     => $this->get('config')->get('psx_sql_user'),
            'password' => $this->get('config')->get('psx_sql_pw'),
            'path'     => PSX_PATH_CACHE . '/population.db',
            'driver'   => 'pdo_sqlite',
        );

        return DriverManager::getConnection($params, $config);
    }

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
