<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Component\Registry;

use Ulrack\Web\Common\Registry\AuthorizationRegistryInterface;

class AuthorizationRegistry implements AuthorizationRegistryInterface
{
    /**
     * Contains the registered authorizations.
     *
     * @var string[]
     */
    private $authorizations;

    /**
     * Constructor.
     *
     * @param array $authorizations
     */
    public function __construct(array $authorizations = [])
    {
        $this->authorizations = $authorizations;
    }

    /**
     * Registers an authorization.
     *
     * @param string $key
     * @param string $serviceKey
     *
     * @return void
     */
    public function register(string $key, string $serviceKey): void
    {
        $this->authorizations[$key] = $serviceKey;
    }

    /**
     * Checks whether the authorization service is registered.
     *
     * @param string $key
     *
     * @return bool
     */
    public function has(string $key): bool
    {
        return isset($this->authorizations[$key]);
    }

    /**
     * Retrieves the service key by the registration key.
     *
     * @param string $key
     *
     * @return string
     */
    public function get(string $key): string
    {
        return $this->authorizations[$key];
    }

    /**
     * Exports all registered authorizations to an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->authorizations;
    }
}
