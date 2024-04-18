<?php

namespace App\Tests\Service;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\HttpClient;

class ApiTest extends TestCase
{
    public function testApiReturns200()
    {
        $client = HttpClient::create();
        $response = $client->request('GET', 'https://demo.gotenberg.dev/');

        $this->assertEquals(200, $response->getStatusCode());
    }
}