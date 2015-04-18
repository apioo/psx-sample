<?php

namespace Sample\Api\InternetPopulation\Endpoint;

use PSX\Api\Documentation\Parser\Raml;
use PSX\Api\Version;
use PSX\Controller\SchemaApiAbstract;
use PSX\Data\RecordInterface;
use PSX\Loader\Context;

class Collection extends SchemaApiAbstract
{
	/**
	 * @Inject
	 * @var PSX\Sql\TableManagerInterface
	 */
	protected $tableManager;
	
	/**
	 * @Inject
	 * @var PSX\Data\SchemaManager
	 */
	protected $schemaManager;

	public function getDocumentation()
	{
		return Raml::fromFile(__DIR__ . '/../Resource/population.raml', $this->context->get(Context::KEY_PATH));
	}

	protected function doGet(Version $version)
	{
		$table = $this->tableManager->getTable('Sample\Api\InternetPopulation\Table');

		return [
			'totalResults' => $table->getCount(),
			'entry'        => $table->getAll(
				$this->queryParameters->getProperty('startIndex'), 
				$this->queryParameters->getProperty('count')
			)
		];
	}

	protected function doCreate(RecordInterface $record, Version $version)
	{
		$record->setDatetime(new \DateTime());

		$this->tableManager
			->getTable('Sample\Api\InternetPopulation\Table')
			->create($record);

		return [
			'success' => true,
			'message' => 'Create successful',
		];
	}

	protected function doUpdate(RecordInterface $record, Version $version)
	{
	}

	protected function doDelete(RecordInterface $record, Version $version)
	{
	}
}
