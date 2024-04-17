<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class GotenbergService
{
    private $client;
    private $apiUrl;

    public function __construct(HttpClientInterface $client, ParameterBagInterface $params)
    {
        $this->client = $client;
        $this->apiUrl = $params->get('api_url');
    }

    public function convertUrlToPdf(string $url, string $outputPath): void
    {
        try {
            $response = $this->client->request('POST', $this->apiUrl, [
                'headers' => [
                    'Content-Type' => 'multipart/form-data'
                ],
                'body' => [
                    'url' => $url
                ]
            ]);

            if ($response->getStatusCode() === 200) {
                file_put_contents($outputPath, $response->getContent());
            }
        } catch (TransportExceptionInterface $e) {
            throw new \Exception($e->getMessage());
        }
    }
}