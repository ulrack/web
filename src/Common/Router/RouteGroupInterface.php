<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Common\Router;

interface RouteGroupInterface
{
    /**
     * Retrieves the configured ports.
     *
     * @return int[]
     */
    public function getPorts(): array;

    /**
     * Retrieves the configured hosts.
     *
     * @return string[]
     */
    public function getHosts(): array;

    /**
     * Retrieves the home route.
     *
     * @return RouteInterface
     */
    public function getRoute(): RouteInterface;

    /**
     * Retrieves the error registry service.
     *
     * @return string
     */
    public function getErrorRegistryService(): string;

    /**
     * Adds authorization to the route.
     *
     * @param string $key
     *
     * @return void
     */
    public function addAuthorization(string $key): void;

    /**
     * Returns a list of authorization services.
     *
     * @return array
     */
    public function getAuthorizations(): array;
}
