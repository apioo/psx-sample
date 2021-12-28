<?php

namespace App\Api\Population;

use App\Model;
use App\Service;
use PSX\Api\Attribute\Incoming;
use PSX\Api\Attribute\Outgoing;
use PSX\Api\Attribute\QueryParam;
use PSX\Dependency\Attribute\Inject;
use PSX\Framework\Controller\ControllerAbstract;
use PSX\Http\Environment\HttpContextInterface;

class Collection extends ControllerAbstract
{
    #[Inject]
    private Service\Population $populationService;

    #[QueryParam(name: "startIndex", type: "integer")]
    #[QueryParam(name: "count", type: "integer")]
    #[Outgoing(code: 200, schema: Model\Collection::class)]
    protected function doGet(HttpContextInterface $context): mixed
    {
        return $this->populationService->getAll(
            $context->getParameter('startIndex'),
            $context->getParameter('count')
        );
    }

    #[Incoming(schema: Model\Population::class)]
    #[Outgoing(code: 200, schema: Model\Message::class)]
    protected function doPost(mixed $record, HttpContextInterface $context): Model\Message
    {
        $this->populationService->create($record);

        return new Model\Message(true, 'Create population successful');
    }
}
