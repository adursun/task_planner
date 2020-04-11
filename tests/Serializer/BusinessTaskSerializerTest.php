<?php


namespace App\Tests\Serializer;

use App\Serializer\BusinessTaskSerializer;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BusinessTaskSerializerTest extends KernelTestCase
{
    private BusinessTaskSerializer $serializer;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->serializer = self::$container->get(BusinessTaskSerializer::class);
    }

    public function testDeserializeOne() : void
    {
        $jsonString = '{ "Business Task 0": { "level": 1, "estimated_duration": 7 } }';
        $task = $this->serializer->deserializeOne($jsonString);

        $this->assertEquals('Business Task 0', $task->getId());
        $this->assertEquals(1, $task->getLevel());
        $this->assertEquals(7, $task->getEstimatedDuration());
    }

    public function testDeserializeMany() : void
    {
        $jsonString = '[{ "Business Task 0": { "level": 1, "estimated_duration": 7 } }, { "Business Task 1": { "level": 3, "estimated_duration": 4 } }]';
        $tasks = $this->serializer->deserializeMany($jsonString);

        $this->assertCount(2, $tasks);

        $this->assertEquals('Business Task 0', $tasks[0]->getId());
        $this->assertEquals(1, $tasks[0]->getLevel());
        $this->assertEquals(7, $tasks[0]->getEstimatedDuration());

        $this->assertEquals('Business Task 1', $tasks[1]->getId());
        $this->assertEquals(3, $tasks[1]->getLevel());
        $this->assertEquals(4, $tasks[1]->getEstimatedDuration());
    }
}
