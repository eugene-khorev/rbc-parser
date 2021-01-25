<?php


namespace App\Common\Parser;


use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class HttpDataProvider implements DataProviderInterface
{

    public function __construct(
        private HttpClientInterface $client
    ) {}

    /**
     * @param string $source
     * @param string $method
     * @return string
     * @throws ExceptionInterface
     */
    public function getData(string $source, string $method = 'GET'): string
    {
        $response = $this->client->request($method, $source);
//        $statusCode = $response->getStatusCode();
//        $contentType = $response->getHeaders()['content-type'][0];
        return $response->getContent();
    }
}
