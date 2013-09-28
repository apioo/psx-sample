<?php

namespace Sample\News;

use Exception;
use DateTime;
use PSX\Data\Record\TableAbstract;
use PSX\Data\WriterResult;
use PSX\Data\WriterInterface;
use PSX\Util\Uuid;

class Record extends TableAbstract
{
	protected $id;
	protected $userId;
	protected $title;
	protected $text;
	protected $date;

	protected $_date;

	public function setId($id)
	{
		$this->id = $id;
	}

	public function setUserId($userId)
	{
		$this->userId = $userId;
	}

	public function setTitle($title)
	{
		if(strlen($title) < 3)
		{
			throw new Exception('Title must have at least 3 signs');
		}

		$this->title = $title;
	}

	public function setText($text)
	{
		$this->text = $text;
	}

	public function setDate($date)
	{
		$this->date = $date;
	}

	public function getDate()
	{
		if($this->_date === null)
		{
			$this->_date = new DateTime($this->date);
		}

		return $this->_date;
	}

	public function export(WriterResult $result)
	{
		switch($result->getType())
		{
			case WriterInterface::RSS:
				$item = $result->getWriter()->createItem();

				$item->setTitle($this->title);
				$item->setGuid('urn:uuid:' . Uuid::nameBased('test:' . $this->id));
				$item->setDescription($this->text);

				return $item;
				break;

			case WriterInterface::ATOM:
				$entry = $result->getWriter()->createEntry();

				$entry->setTitle($this->title);
				$entry->setId('urn:uuid:' . Uuid::nameBased('test:' . $this->id));
				$entry->setUpdated($this->getDate());
				$entry->setContent($this->text, 'html');

				return $entry;
				break;

			default:
				return parent::export($result);
				break;
		}
	}
}