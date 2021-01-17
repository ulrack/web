<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Component\Middleware;

use Ulrack\Web\Common\Endpoint\InputInterface;
use Ulrack\Web\Common\Endpoint\OutputInterface;
use Ulrack\Web\Common\Middleware\MiddlewareInterface;

class HostMatchingMiddleware implements MiddlewareInterface
{
    /**
     * Contains the hosts.
     *
     * @var string[]
     */
    private $hosts;

    /**
     * Constructor.
     *
     * @param string ...$hosts
     */
    public function __construct(string ...$hosts)
    {
        $this->hosts = $hosts;
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
        $requestHost = $input->getRequest()->getUri()->getHost();
        foreach ($this->hosts as $host) {
            if (fnmatch($host, $requestHost)) {
                return true;
            }
        }

        return false;
    }
}
