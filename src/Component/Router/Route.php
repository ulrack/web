<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Component\Router;

use Ulrack\Web\Common\Router\RouteInterface;

class Route implements RouteInterface
{
    /**
     * Contains the path for the route.
     *
     * @var string
     */
    private $path;

    /**
     * Contains the key to the service.
     *
     * @var string
     */
    private $service;

    /**
     * Contains the allowed methods for the route.
     *
     * @var string[]
     */
    private $methods;

    /**
     * Contains the service key for the output handler.
     *
     * @var string|null
     */
    private $outputService;

    /**
     * Contains the service key for the error registry.
     *
     * @var string|null
     */
    private $errorRegistryService;

    /**
     * Contains the sub-routes.
     *
     * @var RouteInterface[]
     */
    private $routes;

    /**
     * Contains the authorizations.
     *
     * @var string[]
     */
    private $authorization = [];

    /**
     * Constructor.
     *
     * @param string $path
     * @param string $service
     * @param string[] $methods
     * @param string $outputService
     * @param string $errorRegistryService
     * @param RouteInterface ...$routes
     */
    public function __construct(
        string $path,
        string $service,
        array $methods,
        string $outputService = null,
        string $errorRegistryService = null,
        RouteInterface ...$routes
    ) {
        $this->path = $path;
        $this->service = $service;
        $this->methods = $methods;
        $this->outputService = $outputService;
        $this->errorRegistryService = $errorRegistryService;
        $this->routes = $routes;
    }

    /**
     * Retrieves the configured path.
     *
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Retrieves the configured service.
     *
     * @return string
     */
    public function getService(): string
    {
        return $this->service;
    }

    /**
     * Retrieves the sub-routes.
     *
     * @return RouteInterface[]
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    /**
     * Adds a sub-route to the route.
     *
     * @param RouteInterface $route
     *
     * @return void
     */
    public function addRoute(RouteInterface $route): void
    {
        $this->routes[] = $route;
    }

    /**
     * Retrieves the output handler service key.
     *
     * @return string|null
     */
    public function getOutputHandlerService(): ?string
    {
        return $this->outputService;
    }

    /**
     * Retrieves the allowed methods for the route.
     *
     * @return string[]
     */
    public function getMethods(): array
    {
        return $this->methods;
    }

    /**
     * Retrieves the error registry service.
     *
     * @return string|null
     */
    public function getErrorRegistryService(): ?string
    {
        return $this->errorRegistryService;
    }

    /**
     * Adds authorization to the route.
     *
     * @param string $key
     *
     * @return void
     */
    public function addAuthorization(string $key): void
    {
        $this->authorization[] = $key;
    }

    /**
     * Returns a list of authorization services.
     *
     * @return array
     */
    public function getAuthorizations(): array
    {
        return $this->authorization;
    }
}
