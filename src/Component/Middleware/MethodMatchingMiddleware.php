<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Component\Middleware;

use Ulrack\Web\Common\Endpoint\InputInterface;
use Ulrack\Web\Common\Endpoint\OutputInterface;
use Ulrack\Web\Common\Middleware\MiddlewareInterface;

class MethodMatchingMiddleware implements MiddlewareInterface
{
    /**
     * Contains the methods.
     *
     * @var string[]
     */
    private $methods;

    /**
     * Constructor.
     *
     * @param string ...$methods
     */
    public function __construct(string ...$methods)
    {
        $this->methods = $methods;
    }

    /**
     * Retrieves the error code for the middleware if it does not pass.
     *
     * @return int
     */
    public function getErrorCode(): int
    {
        return 405;
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
        return in_array($input->getRequest()->getMethod(), $this->methods);
    }
}
