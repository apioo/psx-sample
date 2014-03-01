<?php

namespace Sample\Welcome\Application;

use PSX\Controller\ViewAbstract;

class Index extends ViewAbstract
{
	public function onLoad()
	{
		$this->getTemplate()->assign('title', 'PSX Framework');
		$this->getTemplate()->assign('subTitle', 'Template sample ...');
	}
}
