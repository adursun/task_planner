<?php

namespace App\Service;

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
     * @return \App\Model\ItTask[]
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function getTasks()
    {
        $response = $this->client->request('GET', self::BASE_URL);
        return $this->serializer->deserializeMany($response->getContent());
    }
}
