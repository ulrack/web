<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Factory\Extension;

use Ulrack\Web\Component\Router\RouteGroup;
use Ulrack\Web\Common\Router\RouteGroupInterface;
use Ulrack\Services\Exception\DefinitionNotFoundException;
use Ulrack\Services\Common\AbstractServiceFactoryExtension;

class RouteGroupsFactory extends AbstractServiceFactoryExtension
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
     * Retrieves all route groups.
     *
     * @return RouteGroupInterface[]
     */
    public function getRouteGroups(): array
    {
        $groups = [];
        foreach (array_keys($this->getServices()[$this->getKey()]) as $key) {
            $groups[] = $this->create('route-groups.' . $key);
        }

        return $groups;
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

        $routeGroups = $this->getServices()[$this->getKey()];
        if (isset($routeGroups[$internalKey])) {
            $routeGroup = $this->createRouteGroup(
                $this->resolveReferences(
                    $routeGroups[$internalKey]
                )
            );

            $this->registerService($internalKey, $routeGroup);

            return $this->postCreate(
                $serviceKey,
                $routeGroup,
                $this->getParameters()
            )['return'];
        }

        throw new DefinitionNotFoundException($serviceKey);
    }

    /**
     * Creates a new route group based on the configuration.
     *
     * @param array $routeGroup
     *
     * @return RouteGroupInterface
     */
    private function createRouteGroup(
        array $routeGroup
    ): RouteGroupInterface {
        $newRouteGroup = new RouteGroup(
            $routeGroup['ports'],
            $routeGroup['hosts'],
            $this->superCreate($routeGroup['route']),
            $routeGroup['errorRegistryService'] ?? ''
        );

        foreach ($routeGroup['authorizationServices'] ?? [] as $authorization) {
            $newRouteGroup->addAuthorization($authorization);
        }

        return $newRouteGroup;
    }
}
