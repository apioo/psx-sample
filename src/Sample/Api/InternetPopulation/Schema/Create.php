<?php

namespace Sample\Api\InternetPopulation\Schema;

use PSX\Data\SchemaAbstract;

class Create extends SchemaAbstract
{
	public function getDefinition()
	{
		$entry = $this->getSchema('Sample\Api\InternetPopulation\Schema\Population');
		$entry->getChild('place')->setRequired(true);
		$entry->getChild('region')->setRequired(true);
		$entry->getChild('population')->setRequired(true);
		$entry->getChild('users')->setRequired(true);
		$entry->getChild('world_users')->setRequired(true);

		return $entry;
	}
}
