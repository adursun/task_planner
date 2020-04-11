<?php

namespace App\Serializer;

use App\Model\BusinessTask;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\Encoder\JsonDecode;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class BusinessTaskSerializer
{
    private Serializer $serializer;

    private DecoderInterface $decoder;

    public function __construct(DecoderInterface $decoder)
    {
        $this->decoder = $decoder;

        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer(), new ArrayDenormalizer()];
        $this->serializer = new Serializer($normalizers, $encoders);
    }

    /**
     * @param $data
     * @return BusinessTask
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function deserializeOne($data)
    {
        $item = $this->decoder->decode($data, 'json', [JsonDecode::ASSOCIATIVE => true]);
        assert(1, count($item));

        foreach ($item as $id => $data) {
            $data['id'] = $id;
            /** @var BusinessTask $task */
            $task = $this->serializer->denormalize($data, BusinessTask::class);
        }

        return $task;
    }

    /**
     * @param $data
     * @return BusinessTask[]|array
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function deserializeMany($data)
    {
        $items = $this->decoder->decode($data, 'json', [JsonDecode::ASSOCIATIVE => true]);
        /** @var BusinessTask[] $tasks */
        $tasks = [];

        foreach ($items as $item) {
            foreach ($item as $id => $data) {
                $data['id'] = $id;
                $tasks[] = $this->serializer->denormalize($data, BusinessTask::class);
            }
        }

        return $tasks;
    }
}
