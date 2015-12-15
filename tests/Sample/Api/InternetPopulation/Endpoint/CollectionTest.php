<?php

namespace Sample\Api\InternetPopulation\Endpoint;

use PSX\Http\Request;
use PSX\Http\Response;
use PSX\Http\Stream\TempStream;
use PSX\Test\ControllerDbTestCase;
use PSX\Test\Environment;
use PSX\Url;

class CollectionTest extends ControllerDbTestCase
{
    public function getDataSet()
    {
        return $this->createFlatXMLDataSet(__DIR__ . '/api_fixture.xml');
    }

    public function testGetAll()
    {
        $body     = new TempStream(fopen('php://memory', 'r+'));
        $request  = new Request(new Url('http://127.0.0.1/internet'), 'GET');
        $response = new Response();
        $response->setBody($body);

        $this->loadController($request, $response);

        $body   = (string) $response->getBody();
        $expect = <<<JSON
{
    "totalResults": 10,
    "entry": [
        {
            "id": 10,
            "place": 10,
            "region": "Korea South",
            "population": 48508972,
            "users": 37475800,
            "world_users": 2.2,
            "datetime": "2009-11-29T15:28:06Z"
        },
        {
            "id": 9,
            "place": 9,
            "region": "France",
            "population": 62150775,
            "users": 43100134,
            "world_users": 2.5,
            "datetime": "2009-11-29T15:27:37Z"
        },
        {
            "id": 8,
            "place": 8,
            "region": "Russia",
            "population": 140041247,
            "users": 45250000,
            "world_users": 2.6,
            "datetime": "2009-11-29T15:27:07Z"
        },
        {
            "id": 7,
            "place": 7,
            "region": "United Kingdom",
            "population": 61113205,
            "users": 46683900,
            "world_users": 2.7,
            "datetime": "2009-11-29T15:26:27Z"
        },
        {
            "id": 6,
            "place": 6,
            "region": "Germany",
            "population": 82329758,
            "users": 54229325,
            "world_users": 3.1,
            "datetime": "2009-11-29T15:25:58Z"
        },
        {
            "id": 5,
            "place": 5,
            "region": "Brazil",
            "population": 198739269,
            "users": 67510400,
            "world_users": 3.9,
            "datetime": "2009-11-29T15:25:20Z"
        },
        {
            "id": 4,
            "place": 4,
            "region": "India",
            "population": 1156897766,
            "users": 81000000,
            "world_users": 4.7,
            "datetime": "2009-11-29T15:24:47Z"
        },
        {
            "id": 3,
            "place": 3,
            "region": "Japan",
            "population": 127078679,
            "users": 95979000,
            "world_users": 5.5,
            "datetime": "2009-11-29T15:23:18Z"
        },
        {
            "id": 2,
            "place": 2,
            "region": "United States",
            "population": 307212123,
            "users": 227719000,
            "world_users": 13.1,
            "datetime": "2009-11-29T15:22:40Z"
        },
        {
            "id": 1,
            "place": 1,
            "region": "China",
            "population": 1338612968,
            "users": 360000000,
            "world_users": 20.8,
            "datetime": "2009-11-29T15:21:49Z"
        }
    ]
}
JSON;

        $this->assertEquals(200, $response->getStatusCode(), $body);
        $this->assertJsonStringEqualsJsonString($expect, $body, $body);
    }

    public function testGetLimited()
    {
        $body     = new TempStream(fopen('php://memory', 'r+'));
        $request  = new Request(new Url('http://127.0.0.1/internet?startIndex=4&count=4'), 'GET');
        $response = new Response();
        $response->setBody($body);

        $this->loadController($request, $response);

        $body   = (string) $response->getBody();
        $expect = <<<JSON
{
    "totalResults": 10,
    "entry": [
        {
            "id": 6,
            "place": 6,
            "region": "Germany",
            "population": 82329758,
            "users": 54229325,
            "world_users": 3.1,
            "datetime": "2009-11-29T15:25:58Z"
        },
        {
            "id": 5,
            "place": 5,
            "region": "Brazil",
            "population": 198739269,
            "users": 67510400,
            "world_users": 3.9,
            "datetime": "2009-11-29T15:25:20Z"
        },
        {
            "id": 4,
            "place": 4,
            "region": "India",
            "population": 1156897766,
            "users": 81000000,
            "world_users": 4.7,
            "datetime": "2009-11-29T15:24:47Z"
        },
        {
            "id": 3,
            "place": 3,
            "region": "Japan",
            "population": 127078679,
            "users": 95979000,
            "world_users": 5.5,
            "datetime": "2009-11-29T15:23:18Z"
        }
    ]
}
JSON;

        $this->assertEquals(200, $response->getStatusCode(), $body);
        $this->assertJsonStringEqualsJsonString($expect, $body, $body);
    }

    public function testPost()
    {
        $payload  = json_encode([
            'id'          => 11,
            'place'       => 11,
            'region'      => 'Foo',
            'population'  => 1024,
            'users'       => 512,
            'world_users' => 0.6,
        ]);
        $body     = new TempStream(fopen('php://memory', 'r+'));
        $request  = new Request(new Url('http://127.0.0.1/internet'), 'POST', ['Content-Type' => 'application/json'], $payload);
        $response = new Response();
        $response->setBody($body);

        $this->loadController($request, $response);

        $body   = (string) $response->getBody();
        $expect = <<<JSON
{
    "success": true,
    "message": "Create successful"
}
JSON;

        $this->assertEquals(201, $response->getStatusCode(), $body);
        $this->assertJsonStringEqualsJsonString($expect, $body, $body);

        // check database
        $sql = Environment::getService('connection')->createQueryBuilder()
            ->select('id', 'place', 'region', 'population', 'users', 'world_users')
            ->from('internet_population')
            ->orderBy('id', 'DESC')
            ->setFirstResult(0)
            ->setMaxResults(2)
            ->getSQL();

        $result = Environment::getService('connection')->fetchAll($sql);
        $expect = [
            ['id' => 11, 'place' => 11, 'region' => 'Foo', 'population' => 1024, 'users' => 512, 'world_users' => 0.6],
            ['id' => 10, 'place' => 10, 'region' => 'Korea South', 'population' => 48508972, 'users' => 37475800, 'world_users' => 2.2],
        ];

        $this->assertEquals($expect, $result);
    }

    public function testPut()
    {
        $body     = new TempStream(fopen('php://memory', 'r+'));
        $request  = new Request(new Url('http://127.0.0.1/internet'), 'PUT');
        $response = new Response();
        $response->setBody($body);

        $this->loadController($request, $response);

        $this->assertEquals(405, $response->getStatusCode());
    }

    public function testDelete()
    {
        $body     = new TempStream(fopen('php://memory', 'r+'));
        $request  = new Request(new Url('http://127.0.0.1/internet'), 'DELETE');
        $response = new Response();
        $response->setBody($body);

        $this->loadController($request, $response);

        $body = (string) $response->getBody();

        $this->assertEquals(405, $response->getStatusCode(), $body);
    }

    protected function getPaths()
    {
        return array(
            [['GET', 'POST', 'PUT', 'DELETE'], '/internet', 'Sample\Api\InternetPopulation\Endpoint\Collection'],
        );
    }
}
