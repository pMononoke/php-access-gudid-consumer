<?php

declare(strict_types=1);

namespace MedicalMundi\AccessGudid;

use DomainException;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Client\ClientExceptionInterface;
use RuntimeException;

class AccessGudidConsumer
{
    /**
     * @var ClientInterface
     */
    private $httpClient;

    public function __construct(
        ClientInterface $httpClient
    ) {
        $this->httpClient = $httpClient;
    }

    /**
     * @param string $httpMethod
     * @param string $httpEndpoint
     * @return string
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    private function doSend(string $httpMethod, string $httpEndpoint): string
    {
        // TODO non symfony client
        //$request = $this->httpRequestFactory->createRequest('GET', 'https://www.liip.ch/');

        $request = $this->httpClient->createRequest($httpMethod, $httpEndpoint);

        try {
            $response = $this->httpClient->sendRequest($request);
        } catch (ClientExceptionInterface $e) {
            throw new DomainException($e->getMessage());
        }


//        if (200 !== $response->getStatusCode()) {
//            // TODO improve exception handeling - see php-http doc.
//            throw new RuntimeException('HttpClient  error.');
//        }

        return $response->getBody()->getContents();
    }

    private function percentEncoding(string $url): string
    {
        return urldecode($url);
    }

    private function endpoint(string $queryString = ''): string
    {
        return sprintf('https://%s/api/%s/%s', AccessGudidApi::HOST, AccessGudidApi::API_VERSION, $queryString);
    }

    private function apiResource(string $resourceType, string $queryString = '', string $resourceFormat = AccessGudidApi::ALLOWED_FORMAT['json']): string
    {
        if (!in_array($resourceFormat, AccessGudidApi::ALLOWED_FORMAT)) {
            throw new \InvalidArgumentException('Invalid api format.');
        }

        return sprintf('%s.%s?%s', $resourceType, $resourceFormat, $queryString);
    }

    /**
     * @see https://accessgudid.nlm.nih.gov/resources/developers/parse_udi_api
     *
     * @param string $udiCode
     * @return string
     * @throws ClientExceptionInterface
     */
    public function parseUdi(string $udiCode): string
    {
        $queryString = sprintf('udi=%s', $this->percentEncoding($udiCode));

        $apiResource = $this->apiResource(AccessGudidApi::RESOURCE_PARSE_UDI, $queryString);

        $endpoint = $this->endpoint($apiResource);

        $jsonResponse = $this->doSend('GET', $endpoint);

        return $jsonResponse;
    }

    /**
     * @see https://accessgudid.nlm.nih.gov/resources/developers/device_lookup_api
     *
     * @param string $identifier
     * @return string
     * @throws ClientExceptionInterface
     */
    public function devicesLookup(string $identifier): string
    {
        $queryString = sprintf('di=%s', $this->percentEncoding($identifier));

        $apiResource = $this->apiResource(AccessGudidApi::RESOURCE_DEVICE_LOOKUP, $queryString);

        $endpoint = $this->endpoint($apiResource);

        $jsonResponse = $this->doSend('GET', $endpoint);

        return $jsonResponse;
    }

    /**
     * @see https://accessgudid.nlm.nih.gov/resources/developers/device_history_api
     *
     * @param string $identifier
     * @return string
     * @throws ClientExceptionInterface
     */
    public function devicesHistory(string $identifier): string
    {
        $queryString = sprintf('di=%s', $this->percentEncoding($identifier));

        $apiResource = $this->apiResource(AccessGudidApi::RESOURCE_DEVICES_HISTORY, $queryString);

        $endpoint = $this->endpoint($apiResource);

        $jsonResponse = $this->doSend('GET', $endpoint);

        return $jsonResponse;
    }
}
