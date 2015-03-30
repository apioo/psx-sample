<?php

namespace Sample\Api\InternetPopulation\Endpoint;

use PSX\Api\Documentation;
use PSX\Api\Version;
use PSX\Api\Resource;
use PSX\Controller\SchemaApiAbstract;
use PSX\Data\RecordInterface;
use PSX\Data\Schema\Property;
use PSX\Http\Exception as HttpException;
use PSX\Loader\Context;

class Entity extends SchemaApiAbstract
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
		$resource->addPathParameter(new Property\Integer('id'));

		$resource->addMethod(Resource\Factory::getMethod('GET')
			->addResponse(200, $this->schemaManager->getSchema('Sample\Api\InternetPopulation\Schema\Population'))
		);

		$resource->addMethod(Resource\Factory::getMethod('PUT')
			->setRequest($this->schemaManager->getSchema('Sample\Api\InternetPopulation\Schema\Update'))
			->addResponse(200, $this->schemaManager->getSchema('Sample\Api\InternetPopulation\Schema\Message'))
		);

		$resource->addMethod(Resource\Factory::getMethod('DELETE')
			->addResponse(200, $this->schemaManager->getSchema('Sample\Api\InternetPopulation\Schema\Message'))
		);

		return new Documentation\Simple($resource);
	}

	protected function doGet(Version $version)
	{
		return $this->getInternetPopulation();
	}

	protected function doCreate(RecordInterface $record, Version $version)
	{
	}

	protected function doUpdate(RecordInterface $record, Version $version)
	{
		$population = $this->getInternetPopulation();

		$record->setId($population->getId());

		$this->tableManager
			->getTable('Sample\Api\InternetPopulation\Table')
			->update($record);

		return array(
			'success' => true,
			'message' => 'Update successful',
		);
	}

	protected function doDelete(RecordInterface $record, Version $version)
	{
		$population = $this->getInternetPopulation();

		$record->setId($population->getId());

		$this->tableManager
			->getTable('Sample\Api\InternetPopulation\Table')
			->delete($record);

		return array(
			'success' => true,
			'message' => 'Delete successful',
		);
	}

	protected function getInternetPopulation()
	{
		$result = $this->tableManager
			->getTable('Sample\Api\InternetPopulation\Table')
			->get($this->pathParameters->getProperty('id'));

		if(empty($result))
		{
			throw new HttpException\NotFoundException('Internet population not found');
		}

		return $result;
	}
}
