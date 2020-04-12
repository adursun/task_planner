<?php

namespace App\Tests\Service;

use App\Serializer\ItTaskSerializer;
use App\Service\ItTaskService;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class ItTaskServiceTest extends TestCase
{
    private $mockClient;

    private $service;

    protected function setUp()
    {
        $this->mockClient = $this->createMock(Client::class);
        $this->service = new ItTaskService($this->mockClient, new ItTaskSerializer());
    }

    public function testGetTasksWithEmptyList(): void
    {
        $this->mockClient->method('request')->willReturn(new Response($status=200, $headers=[], $body='[]'));
        $tasks = $this->service->getTasks();

        $this->assertCount(0, $tasks);
        $this->assertEquals([], $tasks);
    }

    public function testGetTasksWithValidList(): void
    {
        $this->mockClient->method('request')->willReturn(new Response($status=200, $headers=[], $body='[
            { "zorluk": 3, "sure": 6, "id": "IT Task 0" },
            { "zorluk": 4, "sure": 6, "id": "IT Task 1" }
        ]'));
        $tasks = $this->service->getTasks();

        $this->assertCount(2, $tasks);
        $this->assertEquals(3 * 6, $tasks[0]->getWorkload());
        $this->assertEquals('IT Task 0', $tasks[0]->getName());
        $this->assertEquals(4 * 6, $tasks[1]->getWorkload());
        $this->assertEquals('IT Task 1', $tasks[1]->getName());
    }
}
