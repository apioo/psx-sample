<?php
/*
 * PSX is a open source PHP framework to develop RESTful APIs.
 * For the current version and informations visit <http://phpsx.org>
 *
 * Copyright 2010-2015 Christoph Kappestein <k42b3.x@gmail.com>
 * 
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * 
 *     http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Sample\Api\InternetPopulation\Endpoint;

use PSX\Http\Request;
use PSX\Http\Response;
use PSX\Http\Stream\TempStream;
use PSX\Test\ControllerTestCase;
use PSX\Url;

/**
 * IndexTest
 *
 * @author  Christoph Kappestein <k42b3.x@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class IndexTest extends ControllerTestCase
{
	public function testGet()
	{
		$body     = new TempStream(fopen('php://memory', 'r+'));
		$request  = new Request(new Url('http://127.0.0.1/api'), 'GET');
		$response = new Response();
		$response->setBody($body);

		$this->loadController($request, $response);

        $router     = getContainer()->get('reverse_router');
        $routePath  = $router->getUrl('PSX\Controller\Tool\RoutingController');
        $docPath    = $router->getUrl('PSX\Controller\Tool\DocumentationController::doIndex');
        $clientPath = $router->getBasePath() . '/documentation';

		$body   = (string) $response->getBody();
		$expect = <<<JSON
{
    "message": "Welcome, this is an PSX sample application. It should help to bootstrap a project by providing all needed files and some examples.",
    "links": [
        {
            "rel": "routing",
            "href": "{$routePath}",
            "title": "Gives an overview of all available routing definitions"
        },
        {
            "rel": "documentation",
            "href": "{$docPath}",
            "title": "Generates an API documentation from all available endpoints"
        },
        {
            "rel": "alternate",
            "href": "{$clientPath}",
            "title": "HTML client to view the API documentation",
            "type": "text\/html"
        }
    ]
}
JSON;

		$this->assertJsonStringEqualsJsonString($expect, $body, $body);
	}

	protected function getPaths()
	{
		return array(
            [['GET'], '/api', 'Sample\Api\InternetPopulation\Endpoint\Index'],
            [['GET'], '/routing', 'PSX\Controller\Tool\RoutingController'],
			[['GET'], '/doc', 'PSX\Controller\Tool\DocumentationController::doIndex'],
		);
	}
}
