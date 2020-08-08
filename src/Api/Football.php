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
        $this->token = '0dfdac559a71453f8594aa357401e3cd';
        $this->headers = ['headers' => ['X-Auth-Token' => $this->token]];
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
            //            'startWeek' => date("Y-m-d", strtotime('monday this week')),
            'startWeek' => date("Y-m-d", strtotime('first day of april this year')),
            'endWeek' => date("Y-m-d", strtotime('sunday this week')),
        ];
    }
}
