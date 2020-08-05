<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Tests\Component\Error;

use PHPUnit\Framework\TestCase;
use Ulrack\Web\Common\Endpoint\InputInterface;
use Ulrack\Web\Common\Endpoint\OutputInterface;
use Ulrack\Web\Component\Error\ConfigurablePlainError;

/**
 * @coversDefaultClass \Ulrack\Web\Component\Error\ConfigurablePlainError
 */
class ConfigurablePlainErrorTest extends TestCase
{
    /**
     * @covers ::__invoke
     * @covers ::__construct
     *
     * @return void
     */
    public function testInvoke(): void
    {
        $errorStatusCode = 404;
        $subject = new ConfigurablePlainError($errorStatusCode);

        $input = $this->createMock(InputInterface::class);
        $output = $this->createMock(OutputInterface::class);

        $output->expects(static::once())
            ->method('setStatusCode')
            ->with($errorStatusCode);

        $output->expects(static::once())
            ->method('setOutput')
            ->with('404: Not Found');

        $output->expects(static::once())
            ->method('setContentType')
            ->with('text/plain');

        $subject->__invoke($input, $output);
    }
}
