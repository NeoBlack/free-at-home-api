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

    protected $path;
    protected $method;
    protected $parameters;

    public function __construct(string $path, string $method, array $parameters = [])
    {
        if (!\in_array($method, [self::METHOD_GET, self::METHOD_POST, self::METHOD_PUT, self::METHOD_DELETE], true)) {
            throw new MethodNotAllowedException('The method "' . $method . '" is not allowed', 1536352833);
        }
        $this->path = $path;
        $this->method = $method;
        $this->parameters = $parameters;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        $tmpPath = $this->path;
        foreach ($this->parameters as $key => $value) {
            $tmpPath = str_replace('{' . $key . '}', $value, $tmpPath);
        }
        return $tmpPath;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }
}
