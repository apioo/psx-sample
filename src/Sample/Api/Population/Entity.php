<?php

namespace Sample\Api\Population;

use PSX\Api\Version;
use PSX\Controller\AnnotationApiAbstract;
use PSX\Data\RecordInterface;

/**
 * @PathParam(name="id", type="integer")
 */
class Entity extends AnnotationApiAbstract
{
    /**
     * @Inject
     * @var \Sample\Service\Population
     */
    protected $populationService;

    /**
     * @Outgoing(code=200, schema="../../Resource/schema/population/entity.json")
     */
    protected function doGet(Version $version)
    {
        return $this->populationService->get(
            $this->pathParameters['id']
        );
    }

    /**
     * @Incoming(schema="../../Resource/schema/population/entity.json")
     * @Outgoing(code=200, schema="../../Resource/schema/population/message.json")
     */
    protected function doPut(RecordInterface $record, Version $version)
    {
        $this->populationService->update(
            $this->pathParameters['id'],
            $record['place'],
            $record['region'],
            $record['population'],
            $record['users'],
            $record['world_users']
        );

        return [
            'success' => true,
            'message' => 'Update successful',
        ];
    }

    /**
     * @Outgoing(code=200, schema="../../Resource/schema/population/message.json")
     */
    protected function doDelete(RecordInterface $record, Version $version)
    {
        $this->populationService->delete(
            $this->pathParameters['id']
        );

        return [
            'success' => true,
            'message' => 'Delete successful',
        ];
    }
}
