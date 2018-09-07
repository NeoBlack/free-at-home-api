<?php
declare(strict_types=1);

/*
 * This file is part of the package neoblack/free-at-home-api.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace NeoBlack\FreeAtHomeApi\Entity;

use NeoBlack\FreeAtHomeApi\Exception\MethodNotAllowedException;

class Route
{
    public const METHOD_GET = 'GET';
    public const METHOD_POST = 'POST';
    public const METHOD_PUT = 'PUT';
    public const METHOD_DELETE = 'DELETE';

    private $allowedMethods = [
        self::METHOD_GET,
        self::METHOD_POST,
        self::METHOD_PUT,
        self::METHOD_DELETE
    ];

    protected $path;
    protected $method;

    public function __construct(string $path, string $method)
    {
        if (!\in_array($method, $this->allowedMethods, true)) {
            throw new MethodNotAllowedException('The method "' . $method . '" is not allowed', 1536352833);
        }
        $this->path = $path;
        $this->method = $method;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }
}
