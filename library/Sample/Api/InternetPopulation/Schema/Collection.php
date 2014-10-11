<?php

namespace Sample\Api\InternetPopulation\Schema;

use PSX\Data\SchemaAbstract;
use PSX\Data\Schema\Property;

class Collection extends SchemaAbstract
{
	public function getDefinition()
	{
		$sb = $this->getSchemaBuilder('collection');
		$sb->arrayType('entry')
			->setPrototype($this->getSchema('Sample\Api\InternetPopulation\Schema\Population'));

		return $sb->getProperty();
	}
}
