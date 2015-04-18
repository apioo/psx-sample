<?php

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
