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

    private $methods = [
        self::DEVICES_GET => ['/devices', Route::METHOD_GET]
    ];

    public function get(string $identifier): Route
    {
        if (!isset($this->methods[$identifier])) {
            throw new UnknownRouteException('The route with identifier "' . $identifier . '" is unknown', 1536351904);
        }
        return new Route($this->methods[$identifier][0], $this->methods[$identifier][1]);
    }
}
