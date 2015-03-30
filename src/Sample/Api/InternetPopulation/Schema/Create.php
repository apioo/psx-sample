<?php

namespace Sample\Api\InternetPopulation\Schema;

use PSX\Data\SchemaAbstract;

class Create extends SchemaAbstract
{
	public function getDefinition()
	{
		$entry = $this->getSchema('Sample\Api\InternetPopulation\Schema\Population');
		$entry->get('id')->setRequired(true);
		$entry->get('place')->setRequired(true);
		$entry->get('region')->setRequired(true);
		$entry->get('population')->setRequired(true);
		$entry->get('users')->setRequired(true);
		$entry->get('world_users')->setRequired(true);

		return $entry;
	}
}
