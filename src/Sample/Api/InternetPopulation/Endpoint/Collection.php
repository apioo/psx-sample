<?php

namespace Sample\Api\InternetPopulation\Endpoint;

use PSX\Api\Documentation;
use PSX\Api\Version;
use PSX\Api\Resource;
use PSX\Controller\SchemaApiAbstract;
use PSX\Data\RecordInterface;
use PSX\Data\Schema\Property;
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
		$resource = new Resource(Resource::STATUS_ACTIVE, $this->context->get(Context::KEY_PATH));

		$resource->addMethod(Resource\Factory::getMethod('GET')
			->addQueryParameter(new Property\Integer('startIndex'))
			->addQueryParameter(new Property\Integer('count'))
			->addResponse(200, $this->schemaManager->getSchema('Sample\Api\InternetPopulation\Schema\Collection'))
		);

		$resource->addMethod(Resource\Factory::getMethod('POST')
			->setRequest($this->schemaManager->getSchema('Sample\Api\InternetPopulation\Schema\Create'))
			->addResponse(201, $this->schemaManager->getSchema('Sample\Api\InternetPopulation\Schema\Message'))
		);

		return new Documentation\Simple($resource);
	}

	protected function doGet(Version $version)
	{
		$result = $this->tableManager
			->getTable('Sample\Api\InternetPopulation\Table')
			->getAll($this->queryParameters->getProperty('startIndex'), 
				$this->queryParameters->getProperty('count'));

		return array(
			'entry' => $result
		);
	}

	protected function doCreate(RecordInterface $record, Version $version)
	{
		$record->setDatetime(new \DateTime());

		$this->tableManager
			->getTable('Sample\Api\InternetPopulation\Table')
			->create($record);

		return array(
			'success' => true,
			'message' => 'Create successful',
		);
	}

	protected function doUpdate(RecordInterface $record, Version $version)
	{
	}

	protected function doDelete(RecordInterface $record, Version $version)
	{
	}
}
