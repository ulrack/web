<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Tests\Component\Request;

use PHPUnit\Framework\TestCase;
use Ulrack\Web\Common\Endpoint\InputInterface;
use Ulrack\Web\Common\Endpoint\OutputInterface;
use Ulrack\Web\Exception\UnauthorizedException;
use Ulrack\Services\Common\ServiceFactoryInterface;
use Ulrack\Web\Common\Request\AuthorizationInterface;
use Ulrack\Web\Component\Request\AuthorizationHandler;
use Ulrack\Web\Common\Registry\AuthorizationRegistryInterface;

/**
 * @coversDefaultClass \Ulrack\Web\Component\Request\AuthorizationHandler
 * @covers \Ulrack\Web\Exception\UnauthorizedException
 */
class AuthorizationHandlerTest extends TestCase
{
    /**
     * @covers ::pass
     * @covers ::getAuthorizationByKey
     * @covers ::__construct
     *
     * @return void
     */
    public function testPass(): void
    {
        $serviceFactory = $this->createMock(ServiceFactoryInterface::class);
        $registry = $this->createMock(AuthorizationRegistryInterface::class);
        $subject = new AuthorizationHandler($serviceFactory, $registry);
        $authorization = $this->createMock(AuthorizationInterface::class);

        $authorizationKeys = ['foo'];
        $input = $this->createMock(InputInterface::class);
        $output = $this->createMock(OutputInterface::class);

        $registry->expects(static::once())
            ->method('has')
            ->with('foo')
            ->willReturn(true);

        $serviceFactory->expects(static::once())
            ->method('create')
            ->with('bar')
            ->willReturn($authorization);

        $registry->expects(static::once())
            ->method('get')
            ->with('foo')
            ->willReturn('bar');

        $authorization->expects(static::once())
            ->method('isAllowed')
            ->with($input, $output)
            ->willReturn(true);

        $this->assertEquals(
            true,
            $subject->pass($authorizationKeys, $input, $output)
        );
    }

    /**
     * @covers ::pass
     * @covers ::getAuthorizationByKey
     * @covers ::__construct
     *
     * @return void
     */
    public function testNoPass(): void
    {
        $serviceFactory = $this->createMock(ServiceFactoryInterface::class);
        $registry = $this->createMock(AuthorizationRegistryInterface::class);
        $subject = new AuthorizationHandler($serviceFactory, $registry);
        $authorization = $this->createMock(AuthorizationInterface::class);

        $authorizationKeys = ['foo'];
        $input = $this->createMock(InputInterface::class);
        $output = $this->createMock(OutputInterface::class);

        $registry->expects(static::once())
            ->method('has')
            ->with('foo')
            ->willReturn(true);

        $serviceFactory->expects(static::once())
            ->method('create')
            ->with('bar')
            ->willReturn($authorization);

        $registry->expects(static::once())
            ->method('get')
            ->with('foo')
            ->willReturn('bar');

        $authorization->expects(static::once())
            ->method('isAllowed')
            ->with($input, $output)
            ->willReturn(false);

        $this->assertEquals(
            false,
            $subject->pass($authorizationKeys, $input, $output)
        );
    }

    /**
     * @covers ::pass
     * @covers ::getAuthorizationByKey
     * @covers ::__construct
     *
     * @return void
     */
    public function testPassError(): void
    {
        $serviceFactory = $this->createMock(ServiceFactoryInterface::class);
        $registry = $this->createMock(AuthorizationRegistryInterface::class);
        $subject = new AuthorizationHandler($serviceFactory, $registry);

        $authorizationKeys = ['foo'];
        $input = $this->createMock(InputInterface::class);
        $output = $this->createMock(OutputInterface::class);

        $registry->expects(static::once())
            ->method('has')
            ->with('foo')
            ->willReturn(false);

        $this->expectException(UnauthorizedException::class);

        $subject->pass($authorizationKeys, $input, $output);
    }
}
