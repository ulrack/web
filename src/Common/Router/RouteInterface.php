<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Common\Router;

interface RouteInterface
{
    /**
     * Retrieves the configured path.
     *
     * @return string
     */
    public function getPath(): string;

    /**
     * Retrieves the configured service.
     *
     * @return string
     */
    public function getService(): string;

    /**
     * Retrieves the sub-routes.
     *
     * @return RouteInterface[]
     */
    public function getRoutes(): array;

    /**
     * Retrieves the allowed methods for the route.
     *
     * @return string[]
     */
    public function getMethods(): array;

    /**
     * Retrieves the output handler service key.
     *
     * @return string|null
     */
    public function getOutputHandlerService(): ?string;

    /**
     * Retrieves the error registry service.
     *
     * @return string|null
     */
    public function getErrorRegistryService(): ?string;

    /**
     * Adds a sub-route to the route.
     *
     * @param RouteInterface $route
     *
     * @return void
     */
    public function addRoute(RouteInterface $route): void;

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
