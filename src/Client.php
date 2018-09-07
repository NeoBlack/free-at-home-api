<?php
declare(strict_types=1);

/*
 * This file is part of the package neoblack/free-at-home-api.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace NeoBlack\FreeAtHomeApi;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use NeoBlack\FreeAtHomeApi\Entity\Credentials;
use NeoBlack\FreeAtHomeApi\Entity\Route;
use NeoBlack\FreeAtHomeApi\Exception\InvalidEndpointException;
use NeoBlack\FreeAtHomeApi\Exception\MissingCredentialsException;
use NeoBlack\FreeAtHomeApi\Exception\MissingEndpointException;
use NeoBlack\FreeAtHomeApi\Service\Router;

class Client
{
    /**
     * @var string
     */
    protected $endpoint;

    /**
     * @var Credentials
     */
    protected $credentials;

    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    public function withEndpoint(string $endpoint): self
    {
        if (!filter_var($endpoint, FILTER_VALIDATE_URL)) {
            throw new InvalidEndpointException('the endpoint has an invalid format', 1536354983);
        }
        $this->endpoint = $endpoint;
        return $this;
    }

    public function withCredentials(string $username, string $password): self
    {
        $this->credentials = new Credentials($username, $password);
        return $this;
    }

    public function getClient(): self
    {
        if ($this->endpoint === null) {
            throw new MissingEndpointException('no endpoint is set, call withEndpoint() before getClient()', 1536354535);
        }
        if ($this->credentials === null) {
            throw new MissingCredentialsException('no credentials is set, call withCredentials() before getClient()', 1536354568);
        }
        $this->client = new \GuzzleHttp\Client([
            'base_uri' => $this->endpoint,
        ]);
        return $this;
    }

    /**
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getDevices(): array
    {
        return $this->callApi((new Router())->get(Router::DEVICES_GET));
    }

    /**
     * @param Route $route
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function callApi(Route $route): array
    {
        $options = [
            'headers' => [],
        ];
        try {
            $response = $this->client->request($route->getMethod(), $route->getPath(), $options);
        } catch (ClientException | ServerException $exception) {
            // 400-level & 500-level errors
            $response = $exception->getResponse();
        }
        return json_decode($response->getBody()->getContents(), true);
    }
}
