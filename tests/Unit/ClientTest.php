<?php
declare(strict_types=1);

/*
 * This file is part of the package neoblack/free-at-home-api.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace NeoBlack\FreeAtHomeApi\Test\Unit\Service;

use NeoBlack\FreeAtHomeApi\Client;
use NeoBlack\FreeAtHomeApi\Exception\InvalidEndpointException;
use NeoBlack\FreeAtHomeApi\Exception\MissingCredentialsException;
use NeoBlack\FreeAtHomeApi\Exception\MissingEndpointException;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    /**
     * @test
     */
    public function getClientWithoutEndpointThrowsException(): void
    {
        $this->expectException(MissingEndpointException::class);
        (new Client())->getClient();
    }

    /**
     * @test
     */
    public function getClientWithoutCredentialsThrowsException(): void
    {
        $this->expectException(MissingCredentialsException::class);
        (new Client())->withEndpoint('https://localhost')->getClient();
    }

    /**
     * @return array
     */
    public function invalidEndpointDataProvider(): array
    {
        return [
            '/' => ['/', false],
            '/foo' => ['/foo', false],
            'foo' => ['foo', false],
            'http://localhost' => ['http://localhost', true],
            'https://localhost' => ['https://localhost', true],
            'http://localhost.foo' => ['http://localhost.foo', true],
            'https://localhost.foo' => ['https://localhost.foo', true],
            'http://localhost.foo/foo/bar' => ['http://localhost.foo/foo/bar', true],
            'https://localhost.foo/foo/bar' => ['https://localhost.foo/foo/bar', true],
            'http://localhost.foo:8888/foo/bar' => ['http://localhost.foo:8888/foo/bar', true],
            'https://localhost.foo:8888/foo/bar' => ['https://localhost.foo:8888/foo/bar', true],
        ];
    }

    /**
     * @test
     * @dataProvider invalidEndpointDataProvider
     */
    public function withEndpointThrowsExceptionForInvalidValues(string $endpoint, $isValid): void
    {
        if (!$isValid) {
            $this->expectException(InvalidEndpointException::class);
        }
        /** @noinspection UnnecessaryAssertionInspection */
        $this->assertInstanceOf(Client::class, (new Client())->withEndpoint($endpoint));
    }

    /**
     * @test
     */
    public function getClientReturnClient(): void
    {
        /** @noinspection UnnecessaryAssertionInspection */
        $this->assertInstanceOf(Client::class, (new Client())
            ->withEndpoint('https://localhost')
            ->withCredentials('foo', 'bar')
            ->getClient());
    }
}
