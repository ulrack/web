<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Tests\Component\Output;

use PHPUnit\Framework\TestCase;
use Ulrack\Web\Common\Endpoint\OutputInterface;
use Ulrack\Web\Component\Output\PlainOutputConverter;

/**
 * @coversDefaultClass \Ulrack\Web\Component\Output\PlainOutputConverter
 */
class PlainOutputConverterTest extends TestCase
{
    /**
     * @covers ::__invoke
     * @covers ::__construct
     *
     * @return void
     */
    public function testInvoke(): void
    {
        $subject = new PlainOutputConverter();

        $output = $this->createMock(OutputInterface::class);

        $output->expects(static::once())
            ->method('getOutput')
            ->willReturn('foo');

        $output->expects(static::once())
            ->method('getContentType')
            ->willReturn('text/plain');

        $this->assertEquals('foo', $subject->__invoke($output));
    }

    /**
     * @covers ::__invoke
     * @covers ::__construct
     *
     * @return void
     */
    public function testInvokeOutputError(): void
    {
        $subject = new PlainOutputConverter();

        $output = $this->createMock(OutputInterface::class);

        $output->expects(static::once())
            ->method('getOutput')
            ->willReturn(['message' => 'Not Found', 'error_code' => 404]);

        $output->expects(static::once())
            ->method('getContentType')
            ->willReturn('text/plain');

        $this->assertEquals('404: Not Found', $subject->__invoke($output));
    }

    /**
     * @covers ::__invoke
     * @covers ::__construct
     *
     * @return void
     */
    public function testInvokeNoOutput(): void
    {
        $subject = new PlainOutputConverter();

        $output = $this->createMock(OutputInterface::class);

        $output->expects(static::once())
            ->method('getOutput')
            ->willReturn('foo');

        $output->expects(static::once())
            ->method('getContentType')
            ->willReturn('application/json');

        $this->assertEquals(null, $subject->__invoke($output));
    }
}
