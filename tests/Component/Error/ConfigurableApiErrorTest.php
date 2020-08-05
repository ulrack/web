<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Tests\Component\Error;

use PHPUnit\Framework\TestCase;
use Ulrack\Web\Common\Endpoint\InputInterface;
use Ulrack\Web\Common\Endpoint\OutputInterface;
use Ulrack\Web\Component\Error\ConfigurableApiError;

/**
 * @coversDefaultClass \Ulrack\Web\Component\Error\ConfigurableApiError
 */
class ConfigurableApiErrorTest extends TestCase
{
    /**
     * @covers ::__invoke
     * @covers ::__construct
     *
     * @return void
     */
    public function testInvoke(): void
    {
        $errorStatusCode = 406;
        $subject = new ConfigurableApiError($errorStatusCode);

        $input = $this->createMock(InputInterface::class);
        $output = $this->createMock(OutputInterface::class);

        $output->expects(static::once())
            ->method('setStatusCode')
            ->with($errorStatusCode);

        $output->expects(static::once())
            ->method('setOutput')
            ->with(
                [
                    'message' => 'Not Acceptable',
                    'error_code' => $errorStatusCode
                ]
            );

        $output->expects(static::once())
            ->method('setContentType')
            ->with('application/json');

        $subject->__invoke($input, $output);
    }
}
