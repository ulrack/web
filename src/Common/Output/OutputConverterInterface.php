<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Common\Output;

use Ulrack\Web\Common\Endpoint\OutputInterface;

interface OutputConverterInterface
{
    /**
     * Converts the registered output to a string.
     *
     * @param OutputInterface $output
     *
     * @return string|null
     */
    public function __invoke(OutputInterface $output): ?string;
}
