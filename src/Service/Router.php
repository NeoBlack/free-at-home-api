<?php
declare(strict_types=1);

/*
 * This file is part of the package neoblack/free-at-home-api.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace NeoBlack\FreeAtHomeApi\Service;

use NeoBlack\FreeAtHomeApi\Entity\Route;
use NeoBlack\FreeAtHomeApi\Exception\UnknownRouteException;

class Router
{
    public const DEVICES_GET = 'DEVICES_GET';
    public const DEVICE_GET = 'DEVICE_GET';
    public const DEVICE_UPDATE = 'DEVICE_UPDATE';
    public const DEVICE_DELETE = 'DEVICE_DELETE';

    private $methods = [
        self::DEVICES_GET => ['/devices', Route::METHOD_GET],
        self::DEVICE_GET => ['/device/{id}', Route::METHOD_GET],
        self::DEVICE_UPDATE => ['/device/{id}', Route::METHOD_PUT],
        self::DEVICE_DELETE => ['/device/{id}', Route::METHOD_DELETE],
    ];

    public function get(string $identifier, array $routeParameter = []): Route
    {
        if (!isset($this->methods[$identifier])) {
            throw new UnknownRouteException('The route with identifier "' . $identifier . '" is unknown', 1536351904);
        }
        return new Route($this->methods[$identifier][0], $this->methods[$identifier][1], $routeParameter);
    }
}
