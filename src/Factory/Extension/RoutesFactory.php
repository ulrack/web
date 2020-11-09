<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Factory\Extension;

use Ulrack\Web\Component\Router\Route;
use Ulrack\Web\Common\Router\RouteInterface;
use Ulrack\Services\Exception\DefinitionNotFoundException;
use Ulrack\Services\Common\AbstractServiceFactoryExtension;

class RoutesFactory extends AbstractServiceFactoryExtension
{
    /**
     * Contains the registered services.
     *
     * @var array
     */
    private $registeredServices = [];

    /**
     * Register a value to a service key.
     *
     * @param string $serviceKey
     * @param mixed $value
     *
     * @return void
     */
    public function registerService(string $serviceKey, $value): void
    {
        $this->registeredServices[$serviceKey] = $value;
    }

    /**
     * Retrieve the parameter from the services.
     *
     * @param string $serviceKey
     *
     * @return mixed
     *
     * @throws DefinitionNotFoundException When the parameter can not be found.
     */
    public function create(string $serviceKey)
    {
        $serviceKey = $this->preCreate(
            $serviceKey,
            $this->getParameters()
        )['serviceKey'];

        $internalKey = preg_replace(
            sprintf('/^%s\\./', preg_quote($this->getKey())),
            '',
            $serviceKey,
            1
        );

        if (isset($this->registeredServices[$internalKey])) {
            return $this->postCreate(
                $serviceKey,
                $this->registeredServices[$internalKey],
                $this->getParameters()
            )['return'];
        }

        $routes = $this->getServices()[$this->getKey()];
        if (isset($routes[$internalKey])) {
            $route = $this->createFromArray(
                $this->resolveReferences(
                    $routes[$internalKey]
                )
            );
            $this->registerService($internalKey, $route);

            return $this->postCreate(
                $serviceKey,
                $route,
                $this->getParameters()
            )['return'];
        }

        throw new DefinitionNotFoundException($serviceKey);
    }

    /**
     * Creates a route from an array.
     *
     * @param array $route
     *
     * @return RouteInterface
     */
    private function createFromArray(array $route): RouteInterface
    {
        $routes = [];
        foreach ($route['routes'] as $subRoute) {
            $routes[] = $this->superCreate($subRoute);
        }

        return $this->createRoute(
            $route,
            ...$routes
        );
    }

    /**
     * Creates the route object.
     *
     * @param array $route
     * @param RouteInterface ...$routes
     *
     * @return RouteInterface
     */
    private function createRoute(
        array $route,
        RouteInterface ...$routes
    ): RouteInterface {
        $newRoute = new Route(
            $route['path'],
            $route['service'],
            $route['methods'],
            $route['outputService'] ?? '',
            $route['errorRegistryService'] ?? '',
            ...$routes
        );

        foreach ($route['authorizationServices'] as $authorization) {
            $newRoute->addAuthorization($authorization);
        }

        return $newRoute;
    }
}
