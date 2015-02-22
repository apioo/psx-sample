<?php

namespace Sample\Api\InternetPopulation\Endpoint;

use PSX\Api\Documentation;
use PSX\Api\Version;
use PSX\Api\View;
use PSX\Controller\SchemaApiAbstract;
use PSX\Data\RecordInterface;
use PSX\Util\Api\FilterParameter;

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
		$message = $this->schemaManager->getSchema('Sample\Api\InternetPopulation\Schema\Message');

		$builder = new View\Builder();
		$builder->setGet($this->schemaManager->getSchema('Sample\Api\InternetPopulation\Schema\Collection'));
		$builder->setPost($this->schemaManager->getSchema('Sample\Api\InternetPopulation\Schema\Create'), $message);
		$builder->setPut($this->schemaManager->getSchema('Sample\Api\InternetPopulation\Schema\Update'), $message);
		$builder->setDelete($this->schemaManager->getSchema('Sample\Api\InternetPopulation\Schema\Delete'), $message);

		return new Documentation\Simple($builder->getView());
	}

	protected function doGet(Version $version)
	{
		$parameter = $this->getFilterParameter();
		$condition = FilterParameter::getCondition($parameter);

		$result = $this->tableManager
			->getTable('Sample\Api\InternetPopulation\Table')
			->getAll($parameter->getStartIndex(), 
				$parameter->getCount(), 
				$parameter->getSortBy(), 
				$parameter->getSortOrder(), 
				$condition);

		return array(
			'entry' => $result
		);
	}

	protected function doCreate(RecordInterface $record, Version $version)
	{
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
		$this->tableManager
			->getTable('Sample\Api\InternetPopulation\Table')
			->delete($record);

		return array(
			'success' => true,
			'message' => 'Delete successful',
		);
	}
}
