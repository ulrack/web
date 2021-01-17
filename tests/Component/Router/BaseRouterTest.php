<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Tests\Component\Endpoint;

use PHPUnit\Framework\TestCase;
use Ulrack\Web\Component\Router\BaseRouter;
use Ulrack\Web\Exception\UnauthorizedException;
use Ulrack\Web\Common\Router\RouterInterface;
use Ulrack\Web\Common\Endpoint\InputInterface;
use Ulrack\Web\Common\Endpoint\OutputInterface;
use Ulrack\Web\Common\Endpoint\EndpointInterface;
use Ulrack\Web\Common\Error\ErrorHandlerInterface;
use Ulrack\Services\Common\ServiceFactoryInterface;
use Ulrack\Web\Common\Output\OutputHandlerInterface;

/**
 * @coversDefaultClass \Ulrack\Web\Component\Router\BaseRouter
 * @covers \Ulrack\Web\Exception\UnauthorizedException
 */
class BaseRouterTest extends TestCase
{
    /**
     * @return void
     *
     * @covers ::__construct
     * @covers ::accepts
     * @covers ::__invoke
     * @covers ::getEndpoint
     */
    public function testComponent(): void
    {
        $router = $this->createMock(RouterInterface::class);
        $outputHandler = $this->createMock(OutputHandlerInterface::class);
        $errorHandler = $this->createMock(ErrorHandlerInterface::class);
        $serviceFactory = $this->createMock(ServiceFactoryInterface::class);
        $subject = new BaseRouter(
            $router,
            $outputHandler,
            $errorHandler,
            $serviceFactory
        );

        $input = $this->createMock(InputInterface::class);
        $output = $this->createMock(OutputInterface::class);
        $router->expects(static::once())
            ->method('accepts')
            ->with($input, $output)
            ->willReturn(true);

        $this->assertEquals(true, $subject->accepts($input, $output));

        $router->expects(static::once())
            ->method('__invoke')
            ->with($input, $output);

        $input->expects(static::once())
            ->method('getParameter')
            ->with('endpoint')
            ->willReturn('services.foo.endpoint');

        $input->expects(static::once())
            ->method('getParameters')
            ->willReturn(['endpoint' => 'services.foo.endpoint']);

        $endpoint = $this->createMock(EndpointInterface::class);
        $serviceFactory->expects(static::once())
            ->method('create')
            ->with(
                'services.foo.endpoint',
                ['endpoint' => 'services.foo.endpoint']
            )->willReturn($endpoint);

        $endpoint->expects(static::once())
            ->method('__invoke')
            ->with($input, $output);

        $outputHandler->expects(static::once())
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
     * @covers ::getEndpoint
     */
    public function testComponentFailure(): void
    {
        $router = $this->createMock(RouterInterface::class);
        $outputHandler = $this->createMock(OutputHandlerInterface::class);
        $errorHandler = $this->createMock(ErrorHandlerInterface::class);
        $serviceFactory = $this->createMock(ServiceFactoryInterface::class);
        $subject = new BaseRouter(
            $router,
            $outputHandler,
            $errorHandler,
            $serviceFactory
        );

        $input = $this->createMock(InputInterface::class);
        $output = $this->createMock(OutputInterface::class);
        $router->expects(static::once())
            ->method('accepts')
            ->with($input, $output)
            ->willReturn(true);

        $this->assertEquals(true, $subject->accepts($input, $output));

        $router->expects(static::once())
            ->method('__invoke')
            ->with($input, $output);

        $input->expects(static::once())
            ->method('getParameter')
            ->with('endpoint')
            ->willReturn('services.foo.endpoint');

        $input->expects(static::once())
            ->method('getParameters')
            ->willReturn(['endpoint' => 'services.foo.endpoint']);

        $endpoint = $this->createMock(EndpointInterface::class);
        $serviceFactory->expects(static::once())
            ->method('create')
            ->with(
                'services.foo.endpoint',
                ['endpoint' => 'services.foo.endpoint']
            )->willReturn($endpoint);

        $exception = new UnauthorizedException();

        $endpoint->expects(static::once())
            ->method('__invoke')
            ->with($input, $output)
            ->willThrowException($exception);

        $errorHandler->expects(static::once())
            ->method('outputByException')
            ->with($exception);

        $subject($input, $output);
    }

    /**
     * @return void
     *
     * @covers ::__construct
     * @covers ::accepts
     * @covers ::__invoke
     */
    public function testComponentNotFound(): void
    {
        $router = $this->createMock(RouterInterface::class);
        $outputHandler = $this->createMock(OutputHandlerInterface::class);
        $errorHandler = $this->createMock(ErrorHandlerInterface::class);
        $serviceFactory = $this->createMock(ServiceFactoryInterface::class);
        $subject = new BaseRouter(
            $router,
            $outputHandler,
            $errorHandler,
            $serviceFactory
        );

        $input = $this->createMock(InputInterface::class);
        $output = $this->createMock(OutputInterface::class);
        $router->expects(static::once())
            ->method('accepts')
            ->with($input, $output)
            ->willReturn(false);

        $this->assertEquals(false, $subject->accepts($input, $output));

        $errorHandler->expects(static::once())
            ->method('outputByCode')
            ->with(404);

        $subject($input, $output);
    }
}
