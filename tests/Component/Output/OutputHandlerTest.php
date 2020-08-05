<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Tests\Component\Output;

use PHPUnit\Framework\TestCase;
use Ulrack\Web\Common\Endpoint\InputInterface;
use Ulrack\Web\Component\Output\OutputHandler;
use Ulrack\Web\Exception\NotAcceptedException;
use Ulrack\Web\Common\Endpoint\OutputInterface;
use Ulrack\Web\Common\Output\HeaderHandlerInterface;
use Ulrack\Web\Common\Output\OutputConverterInterface;

/**
 * @coversDefaultClass \Ulrack\Web\Component\Output\OutputHandler
 * @covers \Ulrack\Web\Exception\NotAcceptedException
 * @covers \Ulrack\Web\Exception\HttpException
 */
class OutputHandlerTest extends TestCase
{
    /**
     * @covers ::__invoke
     * @covers ::__construct
     *
     * @return void
     */
    public function testInvoke(): void
    {
        $headerHandler = $this->createMock(HeaderHandlerInterface::class);
        $outputConverter = $this->createMock(OutputConverterInterface::class);
        $subject = new OutputHandler($headerHandler, $outputConverter);

        $input = $this->createMock(InputInterface::class);
        $output = $this->createMock(OutputInterface::class);

        $outputConverter->expects(static::once())
            ->method('__invoke')
            ->with($output)
            ->willReturn('foo');

        $headerHandler->expects(static::once())
            ->method('__invoke')
            ->with($input, $output);

        ob_start();
        $subject->__invoke($input, $output);
        ob_end_clean();
    }

    /**
     * @covers ::__invoke
     * @covers ::__construct
     *
     * @return void
     */
    public function testInvokeFail(): void
    {
        $headerHandler = $this->createMock(HeaderHandlerInterface::class);
        $outputConverter = $this->createMock(OutputConverterInterface::class);
        $subject = new OutputHandler($headerHandler, $outputConverter);

        $input = $this->createMock(InputInterface::class);
        $output = $this->createMock(OutputInterface::class);

        $outputConverter->expects(static::once())
            ->method('__invoke')
            ->with($output)
            ->willReturn(null);

        $this->expectException(NotAcceptedException::class);

        $subject->__invoke($input, $output);
    }
}
