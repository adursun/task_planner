<?php

namespace App\Service;

use App\Entity\Task;
use App\Model\ItTaskAdapter;
use App\Serializer\ItTaskSerializer;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ItTaskService implements TaskServiceInterface
{
    private const BASE_URL = 'http://www.mocky.io/v2/5d47f24c330000623fa3ebfa';

    private HttpClientInterface $client;

    private ItTaskSerializer $serializer;

    public function __construct(HttpClientInterface $client, ItTaskSerializer $serializer)
    {
        $this->client = $client;
        $this->serializer = $serializer;
    }

    /**
     * @return Task[]|array
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function getTasks()
    {
        $response = $this->client->request('GET', self::BASE_URL);
        $itTasks = $this->serializer->deserializeMany($response->getContent());
        /** @var Task[] $tasks */
        $tasks = [];

        foreach ($itTasks as $itTask) {
            $tasks[] = new Task(new ItTaskAdapter($itTask));
        }

        return $tasks;
    }
}
