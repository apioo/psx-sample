<?php

namespace Sample\Welcome\Application;

use PSX\Controller\ViewAbstract;

class Index extends ViewAbstract
{
	/**
	 * @Inject
	 * @var PSX\Template
	 */
	protected $template;

	public function onLoad()
	{
		parent::onLoad();

		$this->template->assign('title', 'PSX Framework');
		$this->template->assign('subTitle', 'Sample application');
	}
}
