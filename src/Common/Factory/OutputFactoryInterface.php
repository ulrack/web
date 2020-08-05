<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Common\Factory;

use Ulrack\Web\Common\Endpoint\InputInterface;
use Ulrack\Web\Common\Endpoint\OutputInterface;

interface OutputFactoryInterface
{
    /**
     * Creates the output object based on the input object.
     *
     * @param InputInterface $input
     *
     * @return OutputInterface
     */
    public function create(InputInterface $input): OutputInterface;
}
