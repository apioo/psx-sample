<?php

namespace Sample\Api\Application;

use PSX\Atom;
use PSX\Atom\Entry;
use PSX\Atom\Text;
use PSX\Controller\HandlerApiAbstract;
use PSX\Data\WriterInterface;
use PSX\Data\Record\Mapper;
use PSX\Data\Record\Mapper\Rule;
use PSX\Data\RecordInterface;
use PSX\Util\Uuid;

class Api extends HandlerApiAbstract
{
	protected function getDefaultHandler()
	{
		return $this->getDomManager()
			->getHandler('Sample\Api\InternetPopulation\Handler');
	}

	/**
	 * If we want display an atom feed we need to convert our record to an 
	 * Atom\Record. This method does the mapping
	 *
	 * @return PSX\Atom
	 */
	protected function getAtomRecord(RecordInterface $result)
	{
		$atom = new Atom();
		$atom->setTitle('Internet population');
		$atom->setId(Uuid::nameBased($this->config['psx_url']));
		$atom->setUpdated($result->current()->getDatetime());

		$mapper = new Mapper();
		$mapper->setRule(array(
			'id'       => 'id',
			'region'   => 'title',
			'users'    => new Rule('summary', function($text, array $row){
				return new Text(sprintf('%s has a population of %s people %s of them are internet users', $row['region'], $row['population'], $row['users']), 'text');
			}),
			'datetime' => 'updated',
		));

		foreach($result as $row)
		{
			$entry = new Atom\Entry();
			$mapper->map($row, $entry);

			$atom->add($entry);
		}

		return $atom;
	}

	protected function getSupportedWriter()
	{
		return array(WriterInterface::JSON, WriterInterface::JSONP, WriterInterface::XML, WriterInterface::ATOM);
	}
}
