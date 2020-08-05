<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Component\Router;

use Ulrack\Web\Common\Router\RouteInterface;
use Ulrack\Web\Common\Router\PathMatcherInterface;

class PathMatcher implements PathMatcherInterface
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
    ): ?array {
        $routePath = trim($route->getPath(), '/');

        if ($routePath === '') {
            return [
                'path' => $path,
                'parameters' => []
            ];
        }

        $matchParam = preg_match(
            '/{[^\/]+}/',
            $routePath
        );

        if (strpos($path, $routePath) === 0 && !$matchParam) {
            return [
                'path' => $this->stripPath($path, $routePath),
                'parameters' => []
            ];
        }

        if (!$matchParam) {
            return null;
        }

        $replaces = [];
        $newParams = [];
        $pathSlugs = explode('/', $path);
        foreach (explode('/', $routePath) as $key => $slug) {
            if (!isset($pathSlugs[$key])) {
                return null;
            }

            $replace = trim($slug, '{}');
            if ($replace === $slug) {
                if ($pathSlugs[$key] === $slug) {
                    $replaces[] = $slug;
                    continue;
                }

                return null;
            }

            $newParams[$replace] = $pathSlugs[$key];
            $replaces[] = $pathSlugs[$key];
        }

        return [
            'path' => $this->stripPath($path, implode('/', $replaces)),
            'parameters' => $newParams
        ];
    }

    /**
     * Strips a part of the path.
     *
     * @param string $path
     * @param string $strip
     *
     * @return string
     */
    private function stripPath(string $path, string $strip): string
    {
        return preg_replace(sprintf(
            '/^%s/',
            preg_quote($strip . '/', '/')
        ), '', $path, 1);
    }
}
