<?php

namespace App\Services\API;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;

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
     * @throws ExceptionInterface
     */
    public function sportradarCall($url) : array
    {
        $key = '54tkfheubjstvrngbp8f77ah';
        $client = HttpClient::create();
        $response = $client->request('GET', $url.$key);
        $statusCode = $response->getStatusCode();
        if (400 <= $statusCode) {
            return [$statusCode];
        }

        return $response->toArray();
    }
}
