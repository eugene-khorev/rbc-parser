<?php


namespace App\Common\Parser;


use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Component\HttpFoundation\Response;
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
     * @throws ExceptionInterface|ClientException
     */
    public function getData(string $source, string $method = 'GET'): string
    {
        // Run HTTP request
        $response = $this->client->request($method, $source);

        // Check status code
        $statusCode = $response->getStatusCode();
        if ($statusCode !== Response::HTTP_OK) {
            throw new ClientException($response);
        }

        return $response->getContent();
    }
}
