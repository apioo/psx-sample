<?php

namespace Sample\Api\InternetPopulation\Schema;

use PSX\Data\SchemaAbstract;

class Delete extends SchemaAbstract
{
	public function getDefinition()
	{
		$entry = $this->getSchema('Sample\Api\InternetPopulation\Schema\Population');
		$entry->get('id')->setRequired(true);

		return $entry;
	}
}
