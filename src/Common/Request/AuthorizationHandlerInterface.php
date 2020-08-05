<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Common\Request;

use Ulrack\Web\Common\Endpoint\InputInterface;
use Ulrack\Web\Common\Endpoint\OutputInterface;

interface AuthorizationHandlerInterface
{
    /**
     * Checks whether the authorization passes.
     *
     * @param string[] $authorizationKeys
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return bool
     */
    public function pass(
        array $authorizationKeys,
        InputInterface $input,
        OutputInterface $output
    ): bool;
}
