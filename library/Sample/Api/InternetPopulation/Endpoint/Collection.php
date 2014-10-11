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
	 * @var PSX\Sql\TableManager
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

		$view = new View();
		$view->setGet($this->schemaManager->getSchema('Sample\Api\InternetPopulation\Schema\Collection'));
		$view->setPost($this->schemaManager->getSchema('Sample\Api\InternetPopulation\Schema\Create'), $message);
		$view->setPut($this->schemaManager->getSchema('Sample\Api\InternetPopulation\Schema\Update'), $message);
		$view->setDelete($this->schemaManager->getSchema('Sample\Api\InternetPopulation\Schema\Delete'), $message);

		return new Documentation\Simple($view);
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

	protected function doPost(RecordInterface $record, Version $version)
	{
		$this->tableManager
			->getTable('Sample\Api\InternetPopulation\Table')
			->create($record);

		return array(
			'success' => true,
			'message' => 'Create successful',
		);
	}

	protected function doPut(RecordInterface $record, Version $version)
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
