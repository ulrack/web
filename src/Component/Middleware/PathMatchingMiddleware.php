<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Component\Middleware;

use Ulrack\Web\Common\Endpoint\InputInterface;
use Ulrack\Web\Common\Endpoint\OutputInterface;
use Ulrack\Web\Common\Middleware\MiddlewareInterface;

class PathMatchingMiddleware implements MiddlewareInterface
{
    /**
     * Contains the route.
     *
     * @var string
     */
    private string $route;

    /**
     * Constructor.
     *
     * @param string $route
     */
    public function __construct(string $route)
    {
        $this->route = $route;
    }

    /**
     * Retrieves the error code for the middleware if it does not pass.
     *
     * @return int
     */
    public function getErrorCode(): int
    {
        return 404;
    }

    /**
     * Performs additional checks on the route.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return bool
     */
    public function pass(
        InputInterface $input,
        OutputInterface $output
    ): bool {
        $parameters = $this->getParameters(
            $this->route,
            $input->getRequest()->getUri()->getPath()
        );

        if ($parameters === null) {
            return false;
        }

        foreach ($parameters as $key => $parameter) {
            $input->setParameter($key, $parameter);
        }

        return true;
    }

    /**
     * Compares the path and retrieves the parameters from the requested URL.
     *
     * @param string $route
     * @param string $path
     *
     * @return array|null An array of parameters or null.
     */
    private function getParameters(
        string $route,
        string $path
    ): ?array {
        $route = trim($route, '/');
        $path = trim($path, '/');

        $matchParam = preg_match(
            '/{[^\/]+}/',
            $route
        );

        if ($path === $route && !$matchParam) {
            return [];
        }

        $pathSlugs = explode('/', $path);
        $routeSlugs = explode('/', $route);

        if (!$matchParam || count($pathSlugs) !== count($routeSlugs)) {
            return null;
        }

        $replaces = [];
        $newParams = [];
        foreach ($routeSlugs as $key => $slug) {
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

        return $newParams;
    }
}
