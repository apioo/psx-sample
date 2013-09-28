<?php

namespace Sample\News;

use PSX\Sql\TableAbstract;

class Table extends TableAbstract
{
	public function getName()
	{
		return 'news';
	}

	public function getColumns()
	{
		return array(

			'id' => self::TYPE_INT | 10 | self::PRIMARY_KEY | self::AUTO_INCREMENT,
			'userId' => self::TYPE_INT | 10,
			'title' => self::TYPE_VARCHAR | 64,
			'text' => self::TYPE_TEXT,
			'date' => self::TYPE_DATETIME,

		);
	}
}
