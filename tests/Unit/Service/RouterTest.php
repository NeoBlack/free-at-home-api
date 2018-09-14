<?php
declare(strict_types=1);

/*
 * This file is part of the package neoblack/free-at-home-api.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace NeoBlack\FreeAtHomeApi\Test\Unit\Service;

use NeoBlack\FreeAtHomeApi\Entity\Route;
use NeoBlack\FreeAtHomeApi\Exception\UnknownRouteException;
use NeoBlack\FreeAtHomeApi\Service\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    public function routeDataProvider(): array
    {
        return [
            'identifier: ' . Router::DEVICES_GET  => [Router::DEVICES_GET, '/devices', Route::METHOD_GET],
            'identifier: ' . Router::DEVICE_GET  => [Router::DEVICE_GET, '/device/{id}', Route::METHOD_GET],
            'identifier: ' . Router::DEVICE_UPDATE  => [Router::DEVICE_UPDATE, '/device/{id}', Route::METHOD_PUT],
            'identifier: ' . Router::DEVICE_DELETE  => [Router::DEVICE_DELETE, '/device/{id}', Route::METHOD_DELETE],
        ];
    }

    /**
     * @test
     * @dataProvider routeDataProvider
     * @param string $identifier
     * @param string $expectedPath
     * @param string $expectedMethod
     */
    public function getCreatesCorrectRouteObject(string $identifier, string $expectedPath, string $expectedMethod): void
    {
        $route = (new Router())->get($identifier);
        $this->assertSame($expectedPath, $route->getPath());
        $this->assertSame($expectedMethod, $route->getMethod());
    }

    /**
     * @test
     */
    public function getThrowsExceptionForInvalidIdentifier(): void
    {
        $this->expectException(UnknownRouteException::class);
        /** @noinspection PhpUnusedLocalVariableInspection */
        $route = (new Router())->get('foo');
    }
}
