<?php

namespace Sample\Api\InternetPopulation\Schema;

use PSX\Data\SchemaAbstract;

class Population extends SchemaAbstract
{
	public function getDefinition()
	{
		$sb = $this->getSchemaBuilder('entry');
		$sb->integer('id');
		$sb->string('place')
			->setMinLength(3)
			->setMaxLength(64)
			->setPattern('[A-z]+');
		$sb->string('region')
			->setMinLength(3)
			->setMaxLength(64)
			->setPattern('[A-z]+');
		$sb->integer('population');
		$sb->integer('users');
		$sb->float('world_users');
		$sb->dateTime('datetime');

		return $sb->getProperty();
	}
}
