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

	/**
	 * @Inject
	 * @var PSX\Loader\ReverseRouter
	 */
	protected $reverseRouter;

	public function onLoad()
	{
		parent::onLoad();

		$this->setBody(array(
			'message' => 'Welcome, this is an PSX sample application. It should help to bootstrap a project by providing all needed files and some examples.',
			'links'   => array(
				array(
					'rel'  => 'routing',
					'href' => $this->reverseRouter->getUrl('PSX\Controller\Tool\RoutingController'),
					'meta' => 'Gives an overview of all available routing definitions',
				),
				array(
					'rel'  => 'console',
					'href' => $this->reverseRouter->getUrl('PSX\Controller\Tool\RestController'),
					'meta' => 'An javascript based REST API console to execute HTTP request',
				),
				array(
					'rel'  => 'documentation',
					'href' => $this->reverseRouter->getUrl('PSX\Controller\Tool\DocumentationController'),
					'meta' => 'Generates an API documentation from all available endpoints',
				),
			)
		));
	}
}
