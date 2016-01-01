<?php

namespace Sample\Api\Population;

use PSX\Api\Documentation\Parser\Raml;
use PSX\Api\Version;
use PSX\Controller\SchemaApiAbstract;
use PSX\Data\RecordInterface;
use PSX\Loader\Context;

class Collection extends SchemaApiAbstract
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
        return $this->populationService->getAll(
            $this->queryParameters->getProperty('startIndex'),
            $this->queryParameters->getProperty('count')
        );
    }

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
