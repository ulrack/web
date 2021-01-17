<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Tests\Component\Endpoint;

use PHPUnit\Framework\TestCase;
use Ulrack\Web\Common\Endpoint\InputInterface;
use Ulrack\Web\Common\Endpoint\OutputInterface;
use Ulrack\Web\Common\Middleware\MiddlewareInterface;
use Ulrack\Web\Component\Middleware\MiddlewareAggregate;

/**
 * @coversDefaultClass \Ulrack\Web\Component\Middleware\MiddlewareAggregate
 */
class MiddlewareAggregateTest extends TestCase
{
    /**
     * @return void
     *
     * @covers ::__construct
     * @covers ::getErrorCode
     * @covers ::pass
     */
    public function testComponent(): void
    {
        $middlewareOne = $this->createMock(MiddlewareInterface::class);
        $middlewareTwo = $this->createMock(MiddlewareInterface::class);
        $subject = new MiddlewareAggregate($middlewareOne, $middlewareTwo);
        $this->assertEquals(500, $subject->getErrorCode());
        $input = $this->createMock(InputInterface::class);
        $output = $this->createMock(OutputInterface::class);
        $middlewareOne->expects(static::once())
            ->method('pass')
            ->with($input, $output)
            ->willReturn(true);

        $middlewareTwo->expects(static::once())
            ->method('pass')
            ->with($input, $output)
            ->willReturn(true);

        $this->assertEquals(true, $subject->pass($input, $output));
    }

    /**
     * @return void
     *
     * @covers ::__construct
     * @covers ::getErrorCode
     * @covers ::pass
     */
    public function testComponentFail(): void
    {
        $middlewareOne = $this->createMock(MiddlewareInterface::class);
        $middlewareTwo = $this->createMock(MiddlewareInterface::class);
        $subject = new MiddlewareAggregate($middlewareOne, $middlewareTwo);
        $this->assertEquals(500, $subject->getErrorCode());
        $input = $this->createMock(InputInterface::class);
        $output = $this->createMock(OutputInterface::class);
        $middlewareOne->expects(static::once())
            ->method('pass')
            ->with($input, $output)
            ->willReturn(true);

        $middlewareTwo->expects(static::once())
            ->method('pass')
            ->with($input, $output)
            ->willReturn(false);

        $middlewareTwo->expects(static::once())
            ->method('getErrorCode')
            ->willReturn(404);

        $this->assertEquals(false, $subject->pass($input, $output));
        $this->assertEquals(404, $subject->getErrorCode());
    }
}
