<?php

namespace Sample\Api\Population;

use PSX\Api\Documentation\Parser\Raml;
use PSX\Api\Version;
use PSX\Controller\SchemaApiAbstract;
use PSX\Data\RecordInterface;
use PSX\Http\Exception as HttpException;
use PSX\Loader\Context;

class Entity extends SchemaApiAbstract
{
    /**
     * @Inject
     * @var \Sample\Service\Population
     */
    protected $populationService;

    public function getDocumentation()
    {
        return Raml::fromFile(__DIR__ . '/../../Resource/population.raml', $this->context->get(Context::KEY_PATH));
    }

    protected function doGet(Version $version)
    {
        return $this->populationService->get(
            $this->pathParameters['id']
        );
    }

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
