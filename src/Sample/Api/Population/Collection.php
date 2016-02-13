<?php

namespace Sample\Api\Population;

use PSX\Api\Version;
use PSX\Controller\AnnotationApiAbstract;
use PSX\Data\RecordInterface;

class Collection extends AnnotationApiAbstract
{
    /**
     * @Inject
     * @var \Sample\Service\Population
     */
    protected $populationService;

    /**
     * @QueryParam(name="startIndex", type="integer")
     * @QueryParam(name="count", type="integer")
     * @Outgoing(code=200, schema="../../Resource/schema/population/collection.json")
     */
    protected function doGet(Version $version)
    {
        return $this->populationService->getAll(
            $this->queryParameters->getProperty('startIndex'),
            $this->queryParameters->getProperty('count')
        );
    }

    /**
     * @Incoming(schema="../../Resource/schema/population/entity.json")
     * @Outgoing(code=201, schema="../../Resource/schema/population/message.json")
     */
    protected function doPost(RecordInterface $record, Version $version)
    {
        $this->populationService->create(
            $record['place'],
            $record['region'],
            $record['population'],
            $record['users'],
            $record['world_users']
        );

        return [
            'success' => true,
            'message' => 'Create population successful',
        ];
    }
}
