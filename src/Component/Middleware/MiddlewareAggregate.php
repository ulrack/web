<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Component\Middleware;

use Ulrack\Web\Common\Endpoint\InputInterface;
use Ulrack\Web\Common\Endpoint\OutputInterface;
use Ulrack\Web\Common\Middleware\MiddlewareInterface;

class MiddlewareAggregate implements MiddlewareInterface
{
    /**
     * Contains the middlewares.
     *
     * @var MiddlewareInterface[]
     */
    private array $middlewares;

    /**
     * Contains the last error code.
     *
     * @var int
     */
    private int $lastErrorCode = 500;

    /**
     * Constructor.
     *
     * @param MiddlewareInterface ...$middlewares
     */
    public function __construct(MiddlewareInterface ...$middlewares)
    {
        $this->middlewares = $middlewares;
    }

    /**
     * Retrieves the error code for the middleware if it does not pass.
     *
     * @return int
     */
    public function getErrorCode(): int
    {
        return $this->lastErrorCode;
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
        foreach ($this->middlewares as $middleware) {
            if (!$middleware->pass($input, $output)) {
                $this->lastErrorCode = $middleware->getErrorCode();

                return false;
            }
        }

        return true;
    }
}
