<?php

namespace Sample\Demo\Application;

use DateTime;
use PSX\Atom;
use PSX\Atom\Entry;
use PSX\Atom\Text;
use PSX\Data\Message;
use PSX\Data\Record\Mapper;
use PSX\Data\Record\Mapper\Rule;
use PSX\Data\RecordInterface;
use PSX\Data\WriterInterface;
use PSX\Controller\ApiAbstract;
use PSX\Util\Uuid;

class Api extends ApiAbstract
{
	/**
	 * @httpMethod GET
	 * @path /
	 */
	public function getNews()
	{
		try
		{
			$params = $this->getRequestParams();
			$fields = (array) $params['fields'];
			$result = $this->getDomainManager()
				->getDomain('Sample\Demo\InternetPopulation\Domain')
				->getPopulation($fields, 
					$params['startIndex'], 
					$params['count'], 
					$params['sortBy'], 
					$params['sortOrder'], 
					$this->getRequestCondition());

			if($this->isWriter(WriterInterface::ATOM))
			{
				$this->setResponse($this->getAtomRecord($result));
			}
			else
			{
				$this->setResponse($result);
			}
		}
		catch(\Exception $e)
		{
			if($this->isWriter(WriterInterface::ATOM))
			{
				$msg = new Entry();
				$msg->setId(Uuid::nameBased($e->getMessage()));
				$msg->setTitle($e->getMessage());
				$msg->setUpdated(new DateTime());
			}
			else
			{
				$msg = new Message($e->getMessage(), false);
			}

			$this->setResponse($msg);
		}
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

}
