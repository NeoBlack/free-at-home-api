<?php
declare(strict_types=1);

/*
 * This file is part of the package neoblack/free-at-home-api.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace NeoBlack\FreeAtHomeApi\Test\Unit\Entity;

use NeoBlack\FreeAtHomeApi\Entity\Route;
use NeoBlack\FreeAtHomeApi\Exception\MethodNotAllowedException;
use PHPUnit\Framework\TestCase;

class RouteTest extends TestCase
{
    public function routeMethodDataProvider(): array
    {
        return [
            'method GET' => [Route::METHOD_GET],
            'method POST' => [Route::METHOD_POST],
            'method PUT' => [Route::METHOD_PUT],
            'method DELETE' => [Route::METHOD_DELETE],
        ];
    }

    /**
     * @test
     * @dataProvider routeMethodDataProvider
     */
    public function objectCanBeCreated($method): void
    {
        $route = new Route('/api/foo', $method);
        $this->assertSame('/api/foo', $route->getPath());
        $this->assertSame($method, $route->getMethod());
    }

    /**
     * @test
     */
    public function objectCanNotBeCreatedWithWrongMethod(): void
    {
        $this->expectException(MethodNotAllowedException::class);
        $route = new Route('/api/foo', 'FOO');
    }

    /**
     * @test
     * @dataProvider routeMethodDataProvider
     */
    public function objectCanNotBeCreatedWithLowerCaseMethods($method): void
    {
        $this->expectException(MethodNotAllowedException::class);
        $route = new Route('/api/foo', strtolower($method));
    }
}
