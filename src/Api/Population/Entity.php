<?php

namespace App\Api\Population;

use PSX\Framework\Controller\SchemaApiAbstract;
use App\Model\Message;

/**
 * @Title("Population")
 * @Description("and some more long description")
 * @PathParam(name="id", type="integer")
 */
class Entity extends SchemaApiAbstract
{
    /**
     * @Inject
     * @var \App\Service\Population
     */
    protected $populationService;

    /**
     * @Outgoing(code=200, schema="App\Model\Population")
     * @return \PSX\Record\Record
     */
    protected function doGet()
    {
        return $this->populationService->get(
            $this->pathParameters['id']
        );
    }

    /**
     * @Incoming(schema="App\Model\Population")
     * @Outgoing(code=200, schema="App\Model\Message")
     * @param \App\Model\Population $record
     * @return \App\Model\Message
     */
    protected function doPut($record)
    {
        $this->populationService->update(
            $this->pathParameters['id'],
            $record
        );

        return new Message(true, 'Update successful');
    }

    /**
     * @Outgoing(code=200, schema="App\Model\Message")
     * @return \App\Model\Message
     */
    protected function doDelete($record)
    {
        $this->populationService->delete(
            $this->pathParameters['id']
        );

        return new Message(true, 'Delete successful');
    }
}
