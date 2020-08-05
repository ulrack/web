<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Component\Registry;

use Ulrack\Web\Common\Router\RouteGroupInterface;
use Ulrack\Web\Common\Registry\RouteGroupRegistryInterface;

class RouteGroupRegistry implements RouteGroupRegistryInterface
{
    /**
     * Contains the registered route groups.
     *
     * @var RouteGroupInterface[]
     */
    private $routeGroups;

    /**
     * Constructor.
     *
     * @param RouteGroupInterface[] $routeGroups
     */
    public function __construct(array $routeGroups = [])
    {
        $this->routeGroups = $routeGroups;
    }

    /**
     * Registers a route group.
     *
     * @param string $key
     * @param RouteGroupInterface $routeGroup
     *
     * @return void
     */
    public function register(
        string $key,
        RouteGroupInterface $routeGroup
    ): void {
        $this->routeGroups[$key] = $routeGroup;
    }

    /**
     * Checks whether the route group is registered.
     *
     * @param string $key
     *
     * @return bool
     */
    public function has(string $key): bool
    {
        return isset($this->routeGroups[$key]);
    }

    /**
     * Retrieves the route group by a key.
     *
     * @param string $key
     *
     * @return RouteGroupInterface
     */
    public function get(string $key): RouteGroupInterface
    {
        return $this->routeGroups[$key];
    }

    /**
     * Retrieves the registered keys.
     *
     * @return string[]
     */
    public function getKeys(): array
    {
        return array_keys($this->routeGroups);
    }
}
