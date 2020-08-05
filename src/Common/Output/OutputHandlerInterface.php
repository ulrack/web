<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Common\Output;

use Ulrack\Web\Common\Endpoint\InputInterface;
use Ulrack\Web\Common\Endpoint\OutputInterface;

interface OutputHandlerInterface
{
    /**
     * Handles the conversion of the internal output to visible output.
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
