<?php

namespace Sample\Demo\InternetPopulation;

use DOMDocument;
use PSX\Handler\DomHandlerAbstract;
use PSX\Handler\MappingAbstract;
use PSX\Handler\Dom\Mapping;

class Handler extends DomHandlerAbstract
{
	public function getMapping()
	{
		return new Mapping($this->getDom(), 'usage', 'entry', array(
			'id' => MappingAbstract::TYPE_INTEGER | 10 | MappingAbstract::ID_PROPERTY,
			'place' => MappingAbstract::TYPE_INTEGER | 10,
			'region' => MappingAbstract::TYPE_STRING | 32,
			'population' => MappingAbstract::TYPE_INTEGER | 10,
			'users' => MappingAbstract::TYPE_INTEGER | 10,
			'world_users' => MappingAbstract::TYPE_FLOAT | 10,
			'datetime' => MappingAbstract::TYPE_DATETIME,
		));
	}

	protected function getDom()
	{
		$dom = new DOMDocument();
		$dom->load(PSX_PATH_CACHE . '/internet-usage.xml');

		return $dom;
	}
}
