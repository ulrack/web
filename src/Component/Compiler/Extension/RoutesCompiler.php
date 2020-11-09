<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Component\Compiler\Extension;

use RuntimeException;
use Ulrack\Services\Common\AbstractServiceCompilerExtension;

class RoutesCompiler extends AbstractServiceCompilerExtension
{
    /**
     * Compile the services.
     *
     * @param array $services
     *
     * @return array
     */
    public function compile(array $services): array
    {
        $services = $this->preCompile(
            $services,
            $this->getParameters()
        )['services'];

        $inputServices = $services;
        if (count($services['routes'] ?? []) > 0) {
            $services['routes'] = $this->compileRoutes($services['routes']);
        }

        return $this->postCompile(
            $inputServices,
            $services,
            $this->getParameters()
        )['return'];
    }

    /**
     * Compiles the routes.
     *
     * @param array $routes
     *
     * @return array
     */
    private function compileRoutes(array $routes): array
    {
        $routeReferences = [];
        $finalRoutes = [];
        $depth = 0;

        while (count($routes) > 0) {
            foreach ($routes as $key => $route) {
                if (!$this->isRouteReferenced($key, $routes)) {
                    $subRoutes = [];
                    if (isset($routeReferences[$key])) {
                        ksort($routeReferences[$key]);
                        $subRoutes = array_merge(...$routeReferences[$key]);
                    }

                    $newRoute = [
                        'path' => $route['path'],
                        'service' => $route['service'],
                        'methods' => $route['methods'],
                        'outputService' => $route['outputService'] ?? '',
                        'errorRegistryService' => $route['errorRegistryService'] ?? '',
                        'authorizationServices' => $route['authorizationServices'] ?? [],
                        'routes' => $subRoutes
                    ];

                    $routeWeight = $route['weight'] ?? 1000;
                    $finalRoutes[$routeWeight][$key] = $newRoute;
                    if (!empty($route['parent'])) {
                        $routeReferences[$route['parent']][$routeWeight][] = $key;
                    }

                    unset($routes[$key]);
                    continue;
                }
            }

            // Prevent an infinite loop.
            if ($depth >= 256) {
                throw new RuntimeException(
                    'Nesting of routes deeper than 256 limit'
                );
            }
            $depth++;
        }


        ksort($finalRoutes);
        $finalRoutes = array_merge(...$finalRoutes);

        return $finalRoutes;
    }

    /**
     * Determines whether a route has been referenced.
     *
     * @param array $route
     * @param array $routes
     *
     * @return bool
     */
    private function isRouteReferenced(string $routeKey, array $routes): bool
    {
        foreach ($routes as $subRoute) {
            if (($subRoute['parent'] ?? '') === $routeKey) {
                return true;
            }
        }

        return false;
    }
}
