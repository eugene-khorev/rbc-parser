<?php


namespace App\Common\Parser;


use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Class HttpDataProvider
 * Provider that gets data to parse by using HTTP requests
 * @package App\Common\Parser
 */
final class HttpDataProvider implements DataProviderInterface
{

    /**
     * HttpDataProvider constructor.
     * @param HttpClientInterface $client HTTP client service
     */
    public function __construct(
        private HttpClientInterface $client
    ) {}

    /**
     * Request data via HTTP
     * @param string $source URL to request to get data
     * @param string $method HTTP request method
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
