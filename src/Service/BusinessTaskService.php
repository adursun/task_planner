<?php

namespace App\Service;

use App\Entity\Task;
use App\Model\BusinessTaskAdapter;
use App\Serializer\BusinessTaskSerializer;
use GuzzleHttp\Client;

class BusinessTaskService implements TaskServiceInterface
{
    private const BASE_URL = 'http://www.mocky.io/v2/5d47f235330000623fa3ebf7';

    private Client $client;

    private BusinessTaskSerializer $serializer;

    public function __construct(Client $client, BusinessTaskSerializer $serializer)
    {
        $this->client = $client;
        $this->serializer = $serializer;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        $response = $this->client->request('GET', self::BASE_URL);
        return $response->getBody();
    }

    /**
     * @return Task[]|array
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function getTasks()
    {
        $businessTasks = $this->serializer->deserializeMany($this->getContent());
        /** @var Task[] $tasks */
        $tasks = [];

        foreach ($businessTasks as $businessTask) {
            $tasks[] = new Task(new BusinessTaskAdapter($businessTask));
        }

        return $tasks;
    }
}
