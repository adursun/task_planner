<?php

namespace App\Tests\Service;

use App\Serializer\BusinessTaskSerializer;
use App\Service\BusinessTaskService;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class BusinessTaskServiceTest extends TestCase
{
    public function testGetTasksWithEmptyList(): void
    {
        $mockClient = $this->createMock(Client::class);
        $mockClient->method('request')->willReturn(new Response($status=200, $headers=[], $body='[]'));
        $service = new BusinessTaskService($mockClient, new BusinessTaskSerializer());

        $this->assertEquals([], $service->getTasks());
    }
}
