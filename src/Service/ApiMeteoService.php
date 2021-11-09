<?php
namespace App\Service;

use App\Entity\Meteo;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiMeteoService
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function get(String $path): ?object
    {
        $response = $this->client->request('GET', 'http://'.$path)->getContent();

        return json_decode($response);
    }
}