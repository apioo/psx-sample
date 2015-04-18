<?php

namespace Sample\Api\InternetPopulation\Endpoint;

use PSX\Http\Request;
use PSX\Http\Response;
use PSX\Http\Stream\TempStream;
use PSX\Test\ControllerDbTestCase;
use PSX\Url;

class EntityTest extends ControllerDbTestCase
{
    public function getDataSet()
    {
        return $this->createFlatXMLDataSet(__DIR__ . '/api_fixture.xml');
    }

	public function testGet()
	{
		$body     = new TempStream(fopen('php://memory', 'r+'));
		$request  = new Request(new Url('http://127.0.0.1/internet/1'), 'GET');
		$response = new Response();
		$response->setBody($body);

		$this->loadController($request, $response);

		$body   = (string) $response->getBody();
		$expect = <<<JSON
{
    "id": 1,
    "place": 1,
    "region": "China",
    "population": 1338612968,
    "users": 360000000,
    "world_users": 20.8,
    "datetime": "2009-11-29T15:21:49+00:00"
}
JSON;

        $this->assertEquals(200, $response->getStatusCode(), $body);
		$this->assertJsonStringEqualsJsonString($expect, $body, $body);
	}

    public function testPost()
    {
        $body     = new TempStream(fopen('php://memory', 'r+'));
        $request  = new Request(new Url('http://127.0.0.1/internet/1'), 'POST');
        $response = new Response();
        $response->setBody($body);

        $this->loadController($request, $response);

        $body = (string) $response->getBody();

        $this->assertEquals(405, $response->getStatusCode(), $body);
    }

	public function testPut()
	{
        $payload  = json_encode([
            'id'          => 1,
            'place'       => 11,
            'region'      => 'Foo',
            'population'  => 1024,
            'users'       => 512,
            'world_users' => 0.6,
        ]);
		$body     = new TempStream(fopen('php://memory', 'r+'));
		$request  = new Request(new Url('http://127.0.0.1/internet/1'), 'PUT', ['Content-Type' => 'application/json'], $payload);
		$response = new Response();
		$response->setBody($body);

		$this->loadController($request, $response);

		$body   = (string) $response->getBody();
		$expect = <<<JSON
{
    "success": true,
    "message": "Update successful"
}
JSON;

        $this->assertEquals(200, $response->getStatusCode(), $body);
		$this->assertJsonStringEqualsJsonString($expect, $body, $body);

        // check database
        $sql = getContainer()->get('connection')->createQueryBuilder()
            ->select('id', 'place', 'region', 'population', 'users', 'world_users')
            ->from('internet_population')
            ->where('id = :id')
            ->getSQL();

        $result = getContainer()->get('connection')->fetchAssoc($sql, ['id' => 1]);
        $expect = [
            'id' => 1, 
            'place' => 11, 
            'region' => 'Foo', 
            'population' => 1024, 
            'users' => 512, 
            'world_users' => 0.6
        ];

        $this->assertEquals($expect, $result);
	}

    public function testDelete()
    {
        $body     = new TempStream(fopen('php://memory', 'r+'));
        $request  = new Request(new Url('http://127.0.0.1/internet/1'), 'DELETE');
        $response = new Response();
        $response->setBody($body);

        $this->loadController($request, $response);

        $body   = (string) $response->getBody();
        $expect = <<<JSON
{
    "success": true,
    "message": "Delete successful"
}
JSON;

        $this->assertEquals(200, $response->getStatusCode(), $body);
        $this->assertJsonStringEqualsJsonString($expect, $body, $body);

        // check database
        $sql = getContainer()->get('connection')->createQueryBuilder()
            ->select('id', 'place', 'region', 'population', 'users', 'world_users')
            ->from('internet_population')
            ->where('id = :id')
            ->getSQL();

        $result = getContainer()->get('connection')->fetchAssoc($sql, ['id' => 1]);

        $this->assertEmpty($result);
    }

	protected function getPaths()
	{
		return array(
			[['GET', 'POST', 'PUT', 'DELETE'], '/internet/:id', 'Sample\Api\InternetPopulation\Endpoint\Entity'],
		);
	}
}
