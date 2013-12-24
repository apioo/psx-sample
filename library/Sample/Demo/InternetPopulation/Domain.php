<?php

namespace Sample\Demo\InternetPopulation;

use PSX\Domain\DomainAbstract;
use PSX\Sql\Condition;

class Domain extends DomainAbstract
{
	public function getPopulation(array $fields = array(), $startIndex = 0, $count = 16, $sortBy = null, $sortOrder = null, Condition $con = null)
	{
		return $this->getDefaultManager()
			->getHandler('Sample\Demo\InternetPopulation\Handler')
			->getCollection($fields, $startIndex, $count, $sortBy, $sortOrder, $con);
	}
}
