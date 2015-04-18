<?php
/*
 * PSX is a open source PHP framework to develop RESTful APIs.
 * For the current version and informations visit <http://phpsx.org>
 *
 * Copyright 2010-2015 Christoph Kappestein <k42b3.x@gmail.com>
 * 
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * 
 *     http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

$loader = require(__DIR__ . '/../vendor/autoload.php');
$loader->add('Sample', 'tests');

PSX\Bootstrap::setupEnvironment(getContainer()->get('config'));

function getContainer()
{
	static $container;

	if($container === null)
	{
		$container = require_once(__DIR__ . '/../container.php');

		setUpConnection($container);
	}

	return $container;
}

function hasConnection()
{
	return PSX_CONNECTION === true;
}

function setUpConnection($container)
{
	try
	{
		$params = array(
			'url' => 'sqlite:///:memory:'
		);

		$config = new Doctrine\DBAL\Configuration();
		$config->setSQLLogger(new PSX\Sql\Logger($container->get('logger')));

		$connection = Doctrine\DBAL\DriverManager::getConnection($params, $config);
		$fromSchema = $connection->getSchemaManager()->createSchema();

		$toSchema = Sample\Api\InternetPopulation\Endpoint\TestSchema::getSchema();
		$queries  = $fromSchema->getMigrateToSql($toSchema, $connection->getDatabasePlatform());

		foreach($queries as $query)
		{
			$connection->query($query);
		}

		$container->set('connection', $connection);

		define('PSX_CONNECTION', true);

		return;
	}
	catch(Doctrine\DBAL\DBALException $e)
	{
	}

	define('PSX_CONNECTION', false);
}
