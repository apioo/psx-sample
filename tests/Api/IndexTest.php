<?php

namespace App\Tests\Api\Population;

use App\Api\Index;
use PSX\Framework\Controller\Tool;
use PSX\Framework\Test\ControllerTestCase;
use PSX\Framework\Test\Environment;

class IndexTest extends ControllerTestCase
{
    public function testGet()
    {
        $response   = $this->sendRequest('/api', 'GET');
        $router     = Environment::getService('reverse_router');
        $routePath  = $router->getUrl(Tool\RoutingController::class);
        $docPath    = $router->getUrl(Tool\Documentation\IndexController::class);
        $clientPath = $router->getBasePath() . '/documentation/';

        $body   = (string) $response->getBody();
        $expect = <<<JSON
{
    "message": "Welcome, this is a PSX sample application. It should help to bootstrap a project by providing all needed files and some examples.",
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

    protected function getPaths(): array
    {
        return array(
            [['GET'], '/api', Index::class],
            [['GET'], '/routing', Tool\RoutingController::class],
            [['GET'], '/doc', Tool\Documentation\IndexController::class],
        );
    }
}
