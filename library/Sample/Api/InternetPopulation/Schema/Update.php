<?php

namespace Sample\Api\InternetPopulation\Schema;

use PSX\Data\SchemaAbstract;

class Update extends SchemaAbstract
{
	public function getDefinition()
	{
		$entry = $this->getSchema('Sample\Api\InternetPopulation\Schema\Population');
		$entry->getChild('id')->setRequired(true);

		return $entry;
	}
}
