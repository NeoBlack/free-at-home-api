<?php
declare(strict_types=1);

/*
 * This file is part of the package neoblack/free-at-home-api.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace NeoBlack\FreeAtHomeApi\Entity;

use NeoBlack\FreeAtHomeApi\Exception\CredentialsException;

class Credentials
{
    protected $username;
    protected $password;

    public function __construct(string $username, string $password)
    {
        if ($username === '') {
            throw new CredentialsException('username is required', 1536353801);
        }
        if ($password === '') {
            throw new CredentialsException('password is required', 1536353831);
        }
        $this->username = $username;
        $this->password = $password;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
