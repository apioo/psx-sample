<?php

namespace Sample\Api\InternetPopulation\Endpoint;

use PSX\Controller\ApiAbstract;

class Index extends ApiAbstract
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
					'rel'   => 'routing',
					'href'  => $this->reverseRouter->getUrl('PSX\Controller\Tool\RoutingController'),
					'title' => 'Gives an overview of all available routing definitions',
				),
				array(
					'rel'   => 'documentation',
					'href'  => $this->reverseRouter->getUrl('PSX\Controller\Tool\DocumentationController::doIndex'),
					'title' => 'Generates an API documentation from all available endpoints',
				),
				array(
					'rel'   => 'alternate',
					'href'  => $this->reverseRouter->getBasePath() . '/documentation',
					'title' => 'HTML client to view the API documentation',
					'type'  => 'text/html',
				),
			)
		));
	}
}
