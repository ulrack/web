<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Component\Middleware;

use Ulrack\Web\Common\Endpoint\InputInterface;
use Ulrack\Web\Common\Endpoint\OutputInterface;
use Ulrack\Web\Common\Middleware\MiddlewareInterface;

class PortMatchingMiddleware implements MiddlewareInterface
{
    /**
     * Contains the ports.
     *
     * @var int[]
     */
    private $ports;

    /**
     * Constructor.
     *
     * @param int ...$ports
     */
    public function __construct(int ...$ports)
    {
        $this->ports = $ports;
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
        return in_array(
            $input->getRequest()->getUri()->getPort(),
            $this->ports
        );
    }
}
