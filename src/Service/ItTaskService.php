<?php

namespace App\Service;

use App\Entity\Task;
use App\Model\ItTaskAdapter;
use App\Serializer\ItTaskSerializer;
use GuzzleHttp\Client;

class ItTaskService implements TaskServiceInterface
{
    private const BASE_URL = 'http://www.mocky.io/v2/5d47f24c330000623fa3ebfa';

    private Client $client;

    private ItTaskSerializer $serializer;

    public function __construct(Client $client, ItTaskSerializer $serializer)
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
     */
    public function getTasks()
    {

        $itTasks = $this->serializer->deserializeMany($this->getContent());
        /** @var Task[] $tasks */
        $tasks = [];

        foreach ($itTasks as $itTask) {
            $tasks[] = new Task(new ItTaskAdapter($itTask));
        }

        return $tasks;
    }
}
