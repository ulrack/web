<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Common\Request;

use Ulrack\Web\Common\Endpoint\InputInterface;
use Ulrack\Web\Common\Endpoint\OutputInterface;

interface AuthorizationInterface
{
    /**
     * Determines whether the route may be executed under certain conditions.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return bool
     */
    public function isAllowed(
        InputInterface $input,
        OutputInterface $output
    ): bool;
}
