<?php

namespace App\Tests;

use App\Api\Population;
use PSX\Framework\Test\ControllerDbTestCase;

class ApiTestCase extends ControllerDbTestCase
{
    public function getDataSet()
    {
        return include __DIR__ . '/api_fixture.php';
    }

    protected function getPaths(): array
    {
        return array(
            [['ANY'], '/population', Population\Collection::class],
            [['ANY'], '/population/:id', Population\Entity::class],
        );
    }
}
