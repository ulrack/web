<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Common\Registry;

use Ulrack\Web\Common\Router\RouteGroupInterface;

interface RouteGroupRegistryInterface
{
    /**
     * Registers a route group.
     *
     * @param string $key
     * @param RouteGroupInterface $routeGroup
     *
     * @return void
     */
    public function register(string $key, RouteGroupInterface $routeGroup): void;

    /**
     * Checks whether the route group is registered.
     *
     * @param string $key
     *
     * @return bool
     */
    public function has(string $key): bool;

    /**
     * Retrieves the route group by a key.
     *
     * @param string $key
     *
     * @return RouteGroupInterface
     */
    public function get(string $key): RouteGroupInterface;

    /**
     * Retrieves the registered keys.
     *
     * @return string[]
     */
    public function getKeys(): array;
}
