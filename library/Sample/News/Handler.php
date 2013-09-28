<?php

namespace Sample\News;

use PSX\Data\HandlerAbstract;

class Handler extends HandlerAbstract
{
	/**
	 * Returns the last date of an news entry for the last update field in an 
	 * atom feed
	 *
	 * @return string
	 */
	public function getUpdated()
	{
		$sql = 'SELECT `date` FROM ' . $this->table->getName() . ' ORDER BY `date` DESC LIMIT 1';

		return $this->table->getSql()->getField($sql);
	}

	public function getClassName()
	{
		return '\Sample\News\Record';
	}

	public function getClassArgs()
	{
		return array($this->table);
	}
}
