<?php
declare(strict_types=1);

/*
 * This file is part of the package neoblack/free-at-home-api.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace NeoBlack\FreeAtHomeApi\Test\Unit\Fixtures;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

class HttpClient extends Client
{
    /**
     * Create and send an HTTP request.
     *
     * Use an absolute path to override the base path of the client, or a
     * relative path to append to the base path of the client. The URL can
     * contain the query string as well.
     *
     * @param string $method HTTP method.
     * @param string $uri URI object or string.
     * @param array $options Request options to apply.
     *
     * @return ResponseInterface
     */
    public function request($method, $uri = '', array $options = []): ResponseInterface
    {
        $allowedMethods = [
            '/devices' => ['GET'],
            '/device/4711-foo-bar' => ['GET', 'PUT', 'DELETE'],
        ];
        if (\in_array($method, $allowedMethods[$uri], true)) {
            $jsonFile = __DIR__ . '/../Fixtures/json' . $uri . '-' . $method . '.json';
            $json = file_get_contents($jsonFile);
            return new Response(200, [], $json);
        }
        return new Response(500);
    }
}
