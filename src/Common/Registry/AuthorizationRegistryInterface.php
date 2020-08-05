<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Common\Registry;

interface AuthorizationRegistryInterface
{
    /**
     * Registers an authorization.
     *
     * @param string $key
     * @param string $serviceKey
     *
     * @return void
     */
    public function register(string $key, string $serviceKey): void;

    /**
     * Checks whether the authorization service is registered.
     *
     * @param string $key
     *
     * @return bool
     */
    public function has(string $key): bool;

    /**
     * Retrieves the service key by the registration key.
     *
     * @param string $key
     *
     * @return string
     */
    public function get(string $key): string;

    /**
     * Exports all registered authorizations to an array.
     *
     * @return array
     */
    public function toArray(): array;
}
