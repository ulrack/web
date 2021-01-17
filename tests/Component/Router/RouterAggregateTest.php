<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Tests\Component\Endpoint;

use PHPUnit\Framework\TestCase;
use Ulrack\Web\Exception\NotFoundException;
use Ulrack\Web\Common\Router\RouterInterface;
use Ulrack\Web\Common\Endpoint\InputInterface;
use Ulrack\Web\Common\Endpoint\OutputInterface;
use Ulrack\Web\Component\Router\RouterAggregate;

/**
 * @coversDefaultClass \Ulrack\Web\Component\Router\RouterAggregate
 * @covers \Ulrack\Web\Exception\NotFoundException
 */
class RouterAggregateTest extends TestCase
{
    /**
     * @return void
     *
     * @covers ::__construct
     * @covers ::accepts
     * @covers ::__invoke
     */
    public function testComponent(): void
    {
        $routerFail = $this->createMock(RouterInterface::class);
        $router = $this->createMock(RouterInterface::class);
        $subject = new RouterAggregate($routerFail, $router);

        $input = $this->createMock(InputInterface::class);
        $output = $this->createMock(OutputInterface::class);

        $routerFail->expects(static::once())
            ->method('accepts')
            ->with($input, $output)
            ->willReturn(false);

        $router->expects(static::once())
            ->method('accepts')
            ->with($input, $output)
            ->willReturn(true);

        $this->assertEquals(true, $subject->accepts($input, $output));

        $router->expects(static::once())
            ->method('__invoke')
            ->with($input, $output);

        $subject($input, $output);
    }

    /**
     * @return void
     *
     * @covers ::__construct
     * @covers ::accepts
     * @covers ::__invoke
     */
    public function testComponentFail(): void
    {
        $routerFail = $this->createMock(RouterInterface::class);
        $subject = new RouterAggregate($routerFail);

        $input = $this->createMock(InputInterface::class);
        $output = $this->createMock(OutputInterface::class);

        $routerFail->expects(static::once())
            ->method('accepts')
            ->with($input, $output)
            ->willReturn(false);

        $this->assertEquals(false, $subject->accepts($input, $output));

        $this->expectException(NotFoundException::class);

        $subject($input, $output);
    }
}
