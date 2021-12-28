<?php

namespace App\Api\Population;

use App\Model;
use App\Service;
use PSX\Api\Attribute\Description;
use PSX\Api\Attribute\Incoming;
use PSX\Api\Attribute\Outgoing;
use PSX\Api\Attribute\PathParam;
use PSX\Dependency\Attribute\Inject;
use PSX\Framework\Controller\ControllerAbstract;
use PSX\Http\Environment\HttpContextInterface;

#[Description('Some more long description')]
#[PathParam(name: "id", type: "integer")]
class Entity extends ControllerAbstract
{
    #[Inject]
    private Service\Population $populationService;

    #[Outgoing(code: 200, schema: Model\Population::class)]
    protected function doGet(HttpContextInterface $context): mixed
    {
        return $this->populationService->get(
            $context->getUriFragment('id')
        );
    }

    #[Incoming(schema: Model\Population::class)]
    #[Outgoing(code: 200, schema: Model\Message::class)]
    protected function doPut(mixed $record, HttpContextInterface $context): Model\Message
    {
        $this->populationService->update(
            $context->getUriFragment('id'),
            $record
        );

        return new Model\Message(true, 'Update successful');
    }

    #[Outgoing(code: 200, schema: Model\Message::class)]
    protected function doDelete(HttpContextInterface $context): Model\Message
    {
        $this->populationService->delete(
            $context->getUriFragment('id')
        );

        return new Model\Message(true, 'Delete successful');
    }
}
