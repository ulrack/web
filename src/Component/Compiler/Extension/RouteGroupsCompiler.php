<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Component\Compiler\Extension;

use Ulrack\Services\Common\AbstractServiceCompilerExtension;

class RouteGroupsCompiler extends AbstractServiceCompilerExtension
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
        if (count($services['route-groups'] ?? []) > 0) {
            $services['route-groups'] = $this->compileRouteGroups(
                $services['route-groups']
            );
        }

        return $this->postCompile(
            $inputServices,
            $services,
            $this->getParameters()
        )['return'];
    }

    /**
     * Compiles the route groups.
     *
     * @param array $routeGroups
     *
     * @return array
     */
    private function compileRouteGroups(
        array $routeGroups
    ): array {
        $returnGroups = [];
        foreach ($routeGroups as $key => $routeGroup) {
            $returnGroups[$routeGroup['weight'] ?? 1000][$key] = [
                'ports' => $routeGroup['ports'],
                'hosts' => $routeGroup['hosts'],
                'route' => $routeGroup['route'],
                'errorRegistryService' => $routeGroup['errorRegistryService'] ?? '',
                'authorizationServices' => $routeGroup['authorizationServices'] ?? []
            ];
        }

        ksort($returnGroups);

        return array_merge(...$returnGroups);
    }
}
