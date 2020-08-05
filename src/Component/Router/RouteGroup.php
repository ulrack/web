<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Component\Router;

use Ulrack\Web\Common\Router\RouteInterface;
use Ulrack\Web\Common\Router\RouteGroupInterface;

class RouteGroup implements RouteGroupInterface
{
    /**
     * Contains the ports.
     *
     * @var int[]
     */
    private $ports;

    /**
     * Contains the hosts.
     *
     * @var string[]
     */
    private $hosts;

    /**
     * Contains the home route.
     *
     * @var RouteInterface
     */
    private $route;

    /**
     * Contains the authorizations.
     *
     * @var string[]
     */
    private $authorization = [];

    /**
     * Contains the service key for the error registry.
     *
     * @var string
     */
    private $errorRegistryService;

    /**
     * Constructor.
     *
     * @param int[] $ports
     * @param string[] $hosts
     * @param RouteInterface $route
     * @param string $errorRegistryService
     */
    public function __construct(
        array $ports,
        array $hosts,
        RouteInterface $route,
        string $errorRegistryService
    ) {
        $this->ports = $ports;
        $this->hosts = $hosts;
        $this->route = $route;
        $this->errorRegistryService = $errorRegistryService;
    }

    /**
     * Retrieves the configured ports.
     *
     * @return int[]
     */
    public function getPorts(): array
    {
        return $this->ports;
    }

    /**
     * Retrieves the configured hosts.
     *
     * @return string[]
     */
    public function getHosts(): array
    {
        return $this->hosts;
    }

    /**
     * Retrieves the home route.
     *
     * @return RouteInterface
     */
    public function getRoute(): RouteInterface
    {
        return $this->route;
    }

    /**
     * Retrieves the error registry service.
     *
     * @return string
     */
    public function getErrorRegistryService(): string
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
