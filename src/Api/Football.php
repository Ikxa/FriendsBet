<?php


namespace App\Api;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class Football
{
    /**
     * @var HttpClientInterface
     */
    private $client;
    
    /**
     * @var string
     */
    private $token;
    
    /**
     * @var array
     */
    private $headers;
    
    /**
     * Football constructor.
     *
     * @param HttpClientInterface $client
     */
    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
        $this->token = 'b7e7d690b6msh100e659f7617f84p160d2djsne1e1f6d50991';
        $this->headers = ['headers' => ['X-RapidAPI-Key' => $this->token]];
    }
    
    /**
     * @param       $method
     * @param       $uri
     * @param array $headers
     *
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * @return array
     */
    public function sendRequest($method, $uri, $headers = []): array
    {
        if (!empty($headers)) {
            array_merge($headers, $this->headers);
        }
        
        $response = $this->client->request(
            $method,
            $uri,
            $this->headers
        );
        
        $statusCode = $response->getStatusCode();
        $contentType = $response->getHeaders()['content-type'][0];
        $content = $response->getContent();
        $content = $response->toArray();
        
        return $content;
    }
    
    public function getTimes()
    {
        return [
            // 'startWeek' => date("Y-m-d", strtotime('monday this week')),
            'startWeek' => date("Y-m-d", strtotime('first day of january this year')),
            'endWeek' => date("Y-m-d", strtotime('last day of december this year')),
        ];
    }
}
