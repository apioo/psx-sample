<?php

namespace Sample\Api\InternetPopulation\Endpoint;

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
     * @var PSX\Sql\TableManagerInterface
     */
    protected $tableManager;
    
    /**
     * @Inject
     * @var PSX\Data\SchemaManager
     */
    protected $schemaManager;

    public function getDocumentation()
    {
        return Raml::fromFile(__DIR__ . '/../Resource/population.raml', $this->context->get(Context::KEY_PATH));
    }

    protected function doGet(Version $version)
    {
        return $this->getInternetPopulation();
    }

    protected function doPut(RecordInterface $record, Version $version)
    {
        $population = $this->getInternetPopulation();

        $record->setId($population->getId());

        $this->tableManager
            ->getTable('Sample\Api\InternetPopulation\Table')
            ->update($record);

        return [
            'success' => true,
            'message' => 'Update successful',
        ];
    }

    protected function doDelete(RecordInterface $record, Version $version)
    {
        $population = $this->getInternetPopulation();

        $record->setId($population->getId());

        $this->tableManager
            ->getTable('Sample\Api\InternetPopulation\Table')
            ->delete($record);

        return [
            'success' => true,
            'message' => 'Delete successful',
        ];
    }

    protected function getInternetPopulation()
    {
        $result = $this->tableManager
            ->getTable('Sample\Api\InternetPopulation\Table')
            ->get($this->pathParameters->getProperty('id'));

        if (empty($result)) {
            throw new HttpException\NotFoundException('Internet population not found');
        }

        return $result;
    }
}
