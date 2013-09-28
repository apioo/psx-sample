<?php

namespace Sample\News\Api;

use DateTime;
use PSX\Base;
use PSX\Data\ArrayList;
use PSX\Data\Message;
use PSX\Data\WriterResult;
use PSX\Data\WriterInterface;
use PSX\Module\ApiAbstract;
use Sample\News\Table;
use Sample\News\Handler;

class Index extends ApiAbstract
{
	public function onLoad()
	{
		$this->handler = new Handler(new Table($this->getSql()));
	}

	/**
	 * @httpMethod GET
	 * @path /
	 */
	public function getNews()
	{
		try
		{
			$params    = $this->getRequestParams();
			$fields    = (array) $params['fields'];
			$resultSet = $this->handler->getResultSet($fields, 
				$params['startIndex'], 
				$params['count'], 
				$params['sortBy'], 
				$params['sortOrder'], 
				$this->getRequestCondition(),
				$this->getMode());

			$this->setResponse($resultSet);
		}
		catch(\Exception $e)
		{
			$msg = new Message($e->getMessage(), false);

			$this->setResponse($msg);
		}
	}

	/**
	 * @httpMethod GET
	 * @path /@supportedFields
	 */
	public function getSupportedFields()
	{
		try
		{
			$array = new ArrayList($this->handler->getSupportedFields());

			$this->setResponse($array);
		}
		catch(\Exception $e)
		{
			$msg = new Message($e->getMessage(), false);

			$this->setResponse($msg);
		}
	}

	/**
	 * @httpMethod POST
	 * @path /
	 */
	public function insertNews()
	{
		try
		{
			$record = $this->handler->getRecord();
			$record->import($this->getRequest());

			// insert
			$this->handler->create($record);


			$msg = new Message('You have successful create a ' . $record->getName(), true);

			$this->setResponse($msg);
		}
		catch(\Exception $e)
		{
			$msg = new Message($e->getMessage(), false);

			$this->setResponse($msg);
		}
	}

	protected function setWriterConfig(WriterResult $writer)
	{
		switch($writer->getType())
		{
			case WriterInterface::RSS:
				$title       = 'News';
				$link        = $this->getConfig()->get('psx_url');
				$description = 'Example RESTful News API based on PSX ';

				$writer = $writer->getWriter();
				$writer->setConfig($title, $link, $description);
				$writer->setGenerator('psx ' . Base::getVersion());
				break;

			case WriterInterface::ATOM:
				$title   = 'News';
				$id      = $this->getBase()->getUrn('news');
				$updated = new DateTime($this->handler->getUpdated());

				$writer = $writer->getWriter();
				$writer->setConfig($title, $id, $updated);
				$writer->setGenerator('psx ' . Base::getVersion());
				break;
		}
	}

}