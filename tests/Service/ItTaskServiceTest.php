<?php

namespace App\Tests\Service;

use App\Serializer\ItTaskSerializer;
use App\Service\ItTaskService;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class ItTaskServiceTest extends TestCase
{
    public function testGetTasksWithEmptyList(): void
    {
        $mockClient = $this->createMock(Client::class);
        $mockClient->method('request')->willReturn(new Response($status=200, $headers=[], $body="[]"));
        $service = new ItTaskService($mockClient, new ItTaskSerializer());

        $this->assertEquals([], $service->getTasks());
    }
}
