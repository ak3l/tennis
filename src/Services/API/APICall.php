<?php

namespace App\Services\API;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/**
 * Class APICall
 */
class APICall
{
    /**
     * @param $url
     *
     * @return array
     *
     * @throws ClientExceptionInterface|DecodingExceptionInterface|RedirectionExceptionInterface|TransportExceptionInterface|ServerExceptionInterface
     */
    public function sportradarCall($url) : array
    {
        $key = 'n4sa62jq3xrq2ezrdaffjt2z';
        $client = HttpClient::create();
        $response = $client->request('GET', $url.$key);
        $statusCode = $response->getStatusCode();
        if (400 <= $statusCode) {
            return [$statusCode];
        }

        return $response->toArray();
    }
}
