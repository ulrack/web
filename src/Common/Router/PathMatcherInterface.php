<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Common\Router;

interface PathMatcherInterface
{
    /**
     * Matches the path and strips the part that matched.
     *
     * @param RouteInterface $route
     * @param string $path
     *
     * @return array|null
     */
    public function __invoke(
        RouteInterface $route,
        string $path
    ): ?array;
}
