<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class GotenbergService
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function convertUrlToPdf(string $url, string $outputPath): void
    {
        try {
            $response = $this->client->request('POST', 'https://demo.gotenberg.dev/forms/chromium/convert/url', [
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