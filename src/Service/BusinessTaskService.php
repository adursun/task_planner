<?php

namespace App\Service;

use App\Entity\Task;
use App\Model\BusinessTaskAdapter;
use App\Serializer\BusinessTaskSerializer;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class BusinessTaskService implements TaskServiceInterface
{
    private const BASE_URL = 'http://www.mocky.io/v2/5d47f235330000623fa3ebf7';

    private HttpClientInterface $client;

    private BusinessTaskSerializer $serializer;

    public function __construct(HttpClientInterface $client, BusinessTaskSerializer $serializer)
    {
        $this->client = $client;
        $this->serializer = $serializer;
    }

    /**
     * @return Task[]|array
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function getTasks()
    {
        $response = $this->client->request('GET', self::BASE_URL);
        $businessTasks = $this->serializer->deserializeMany($response->getContent());
        /** @var Task[] $tasks */
        $tasks = [];

        foreach ($businessTasks as $businessTask) {
            $tasks[] = new Task(new BusinessTaskAdapter($businessTask));
        }

        return $tasks;
    }
}
