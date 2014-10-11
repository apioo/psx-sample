<?php

namespace Sample\Dependency;

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use PSX\Dependency\DefaultContainer;

class Container extends DefaultContainer
{
	/**
	 * @return Doctrine\DBAL\Connection
	 */
	public function getConnection()
	{
		$config = new Configuration();
		$params = array(
			'user'     => $this->get('config')->get('psx_sql_user'),
			'password' => $this->get('config')->get('psx_sql_pw'),
			'path'     => PSX_PATH_CACHE . '/internet-usage.db',
			'driver'   => 'pdo_sqlite',
		);

		return DriverManager::getConnection($params, $config);
	}
}
