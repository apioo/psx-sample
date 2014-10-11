<?php

namespace Sample\Api\InternetPopulation\Endpoint;

use PSX\Api\Documentation;
use PSX\Api\Version;
use PSX\Api\View;
use PSX\Controller\SchemaApiAbstract;
use PSX\Data\RecordInterface;
use PSX\Util\Api\FilterParameter;
use PSX\Http\Exception as HttpException;

class Entity extends SchemaApiAbstract
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
		$view = new View();
		$view->setGet($this->schemaManager->getSchema('Sample\Api\InternetPopulation\Schema\Population'));

		return new Documentation\Simple($view);
	}

	protected function doGet(Version $version)
	{
		$result = $this->tableManager
			->getTable('Sample\Api\InternetPopulation\Table')
			->get($this->getUriFragment('id'));

		if(!$result instanceof RecordInterface)
		{
			throw new HttpException\NotFoundException('Internet population not found');
		}

		return $result;
	}
}
