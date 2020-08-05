<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Common\Error;

use Ulrack\Web\Common\Endpoint\InputInterface;
use Ulrack\Web\Common\Endpoint\OutputInterface;

interface ErrorInterface
{
    /**
     * Sets the input and output up for an error response.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return void
     */
    public function __invoke(
        InputInterface $input,
        OutputInterface $output
    ): void;
}
