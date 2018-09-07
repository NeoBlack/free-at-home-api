<?php
declare(strict_types=1);

/*
 * This file is part of the package neoblack/free-at-home-api.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace NeoBlack\FreeAtHomeApi\Test\Unit\Entity;

use NeoBlack\FreeAtHomeApi\Entity\Credentials;
use NeoBlack\FreeAtHomeApi\Exception\CredentialsException;
use PHPUnit\Framework\TestCase;

class CredentialsTest extends TestCase
{
    public function credentialsDataProvider(): array
    {
        return [
            'with username and password' => ['username', 'password', null, null],
            'with username and empty password' => ['username', '', CredentialsException::class, 1536353831],
            'with empty username and password' => ['', 'password', CredentialsException::class, 1536353801],
            'with empty username and empty password' => ['', '', CredentialsException::class, 1536353801],
        ];
    }

    /**
     * @test
     * @dataProvider credentialsDataProvider
     * @param string $username
     * @param string $password
     * @param string|null $exceptionClass
     * @param int $exceptionCode
     */
    public function objectCanBeCreated(string $username, string $password, string $exceptionClass = null, int $exceptionCode = null): void
    {
        if ($exceptionClass !== null) {
            $this->expectException($exceptionClass);
        }
        if ($exceptionCode !== null) {
            $this->expectExceptionCode($exceptionCode);
        }
        $credentials = new Credentials($username, $password);
        $this->assertSame($username, $credentials->getUsername());
        $this->assertSame($password, $credentials->getPassword());
    }
}
