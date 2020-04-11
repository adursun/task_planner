<?php

namespace App\Tests\Serializer;

use PHPUnit\Framework\TestCase;
use App\Serializer\ItTaskSerializer;

class ItTaskSerializerTest extends TestCase
{
    public function testDeserializeOne() : void
    {
        $jsonString = '{ "zorluk": 3, "sure": 6, "id": "IT Task 0" }';
        $serializer = new ItTaskSerializer();
        $task = $serializer->deserializeOne($jsonString);

        $this->assertEquals('IT Task 0', $task->getId());
        $this->assertEquals(3, $task->getZorluk());
        $this->assertEquals(6, $task->getSure());
    }

    public function testDeserializeMany() : void
    {
        $jsonString = '[{ "zorluk": 3, "sure": 6, "id": "IT Task 0" }, { "zorluk": 4, "sure": 5, "id": "IT Task 1" }]';
        $serializer = new ItTaskSerializer();
        $tasks = $serializer->deserializeMany($jsonString);

        $this->assertCount(2, $tasks);

        $this->assertEquals('IT Task 0', $tasks[0]->getId());
        $this->assertEquals(3, $tasks[0]->getZorluk());
        $this->assertEquals(6, $tasks[0]->getSure());

        $this->assertEquals('IT Task 1', $tasks[1]->getId());
        $this->assertEquals(4, $tasks[1]->getZorluk());
        $this->assertEquals(5, $tasks[1]->getSure());
    }
}
