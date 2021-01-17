<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Tests\Component\Endpoint;

use PHPUnit\Framework\TestCase;
use Ulrack\Web\Exception\HttpException;
use Ulrack\Web\Common\Router\RouterInterface;
use Ulrack\Web\Common\Endpoint\InputInterface;
use Ulrack\Web\Common\Endpoint\OutputInterface;
use Ulrack\Web\Component\Router\MiddlewareRouter;
use Ulrack\Web\Common\Middleware\MiddlewareInterface;

/**
 * @coversDefaultClass \Ulrack\Web\Component\Router\MiddlewareRouter
 * @covers \Ulrack\Web\Exception\HttpException
 */
class MiddlewareRouterTest extends TestCase
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
        $router = $this->createMock(RouterInterface::class);
        $middlewareAccept = $this->createMock(MiddlewareInterface::class);
        $middlewareInvoke = $this->createMock(MiddlewareInterface::class);
        $subject = new MiddlewareRouter(
            $router,
            $middlewareAccept,
            $middlewareInvoke
        );

        $input = $this->createMock(InputInterface::class);
        $output = $this->createMock(OutputInterface::class);

        $middlewareAccept->expects(static::once())
            ->method('pass')
            ->with($input, $output)
            ->willReturn(true);

        $router->expects(static::once())
            ->method('accepts')
            ->with($input, $output)
            ->willReturn(true);

        $subject->accepts($input, $output);

        $middlewareInvoke->expects(static::once())
            ->method('pass')
            ->with($input, $output)
            ->willReturn(true);

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
        $router = $this->createMock(RouterInterface::class);
        $middlewareAccept = $this->createMock(MiddlewareInterface::class);
        $middlewareInvoke = $this->createMock(MiddlewareInterface::class);
        $subject = new MiddlewareRouter(
            $router,
            $middlewareAccept,
            $middlewareInvoke
        );

        $input = $this->createMock(InputInterface::class);
        $output = $this->createMock(OutputInterface::class);

        $middlewareAccept->expects(static::once())
            ->method('pass')
            ->with($input, $output)
            ->willReturn(false);

        $subject->accepts($input, $output);

        $middlewareInvoke->expects(static::once())
            ->method('pass')
            ->with($input, $output)
            ->willReturn(false);

        $this->expectException(HttpException::class);
        $subject($input, $output);
    }
}
