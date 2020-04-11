<?php

namespace App\Serializer;

use App\Model\ItTask;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ItTaskSerializer
{
    private const ATTRIBUTES = ['id', 'sure', 'zorluk'];

    private Serializer $serializer;

    public function __construct()
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer(), new ArrayDenormalizer()];
        $this->serializer = new Serializer($normalizers, $encoders);
    }

    /**
     * @param string $data
     * @return ItTask
     */
    public function deserializeOne($data)
    {
        /** @var ItTask $task */
        $task = $this->serializer->deserialize($data, 'App\Model\ItTask', 'json', [
            AbstractNormalizer::ATTRIBUTES => self::ATTRIBUTES
        ]);

        return $task;
    }

    /**
     * @param string $data
     * @return ItTask[]
     */
    public function deserializeMany($data)
    {
        /** @var ItTask[] $tasks */
        $tasks = $this->serializer->deserialize($data, 'App\Model\ItTask[]', 'json', [
            AbstractNormalizer::ATTRIBUTES => self::ATTRIBUTES
        ]);

        return $tasks;
    }
}
