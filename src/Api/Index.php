<?php

namespace App\Api;

use PSX\Dependency\Attribute\Inject;
use PSX\Framework\Controller\ControllerAbstract;
use PSX\Framework\Controller\Tool;
use PSX\Framework\Loader\ReverseRouter;
use PSX\Http\Environment\HttpContextInterface;

class Index extends ControllerAbstract
{
    #[Inject]
    private ReverseRouter $reverseRouter;

    public function doGet(HttpContextInterface $context): array
    {
        return [
            'message' => 'Welcome, this is a PSX sample application. It should help to bootstrap a project by providing all needed files and some examples.',
            'links'   => [
                [
                    'rel'   => 'routing',
                    'href'  => $this->reverseRouter->getUrl(Tool\RoutingController::class),
                    'title' => 'Gives an overview of all available routing definitions',
                ],
                [
                    'rel'   => 'documentation',
                    'href'  => $this->reverseRouter->getUrl(Tool\Documentation\IndexController::class),
                    'title' => 'Generates an API documentation from all available endpoints',
                ],
                [
                    'rel'   => 'alternate',
                    'href'  => $this->reverseRouter->getBasePath() . '/documentation/',
                    'title' => 'HTML client to view the API documentation',
                    'type'  => 'text/html',
                ],
            ]
        ];
    }
}
