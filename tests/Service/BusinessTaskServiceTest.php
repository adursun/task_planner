<?php

namespace App\Tests\Service;

use App\Serializer\BusinessTaskSerializer;
use App\Service\BusinessTaskService;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class BusinessTaskServiceTest extends TestCase
{
    private $mockClient;

    private $service;

    protected function setUp()
    {
        $this->mockClient = $this->createMock(Client::class);
        $this->service = new BusinessTaskService($this->mockClient, new BusinessTaskSerializer());
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
            { "Business Task 0": { "level": 1, "estimated_duration": 7 } },
            { "Business Task 1": { "level": 3, "estimated_duration": 4 } }
        ]'));
        $tasks = $this->service->getTasks();

        $this->assertCount(2, $tasks);
        $this->assertEquals(1 * 7, $tasks[0]->getWorkload());
        $this->assertEquals('Business Task 0', $tasks[0]->getName());
        $this->assertEquals(3 * 4, $tasks[1]->getWorkload());
        $this->assertEquals('Business Task 1', $tasks[1]->getName());
    }
}
