<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Tests\Factory;

use PHPUnit\Framework\TestCase;
use Ulrack\Web\Factory\OutputFactory;
use Ulrack\Web\Common\Endpoint\InputInterface;
use Ulrack\Web\Common\Endpoint\OutputInterface;
use GrizzIt\Http\Common\Request\RequestInterface;

/**
 * @coversDefaultClass \Ulrack\Web\Factory\OutputFactory
 */
class OutputFactoryTest extends TestCase
{
    /**
     * @covers ::create
     * @covers ::parseAcceptHeader
     *
     * @return void
     */
    public function testCreate(): void
    {
        $subject = new OutputFactory();

        $input = $this->createMock(InputInterface::class);
        $request = $this->createMock(RequestInterface::class);

        $input->expects(static::once())
            ->method('getRequest')
            ->willReturn($request);

        $request->expects(static::once())
            ->method('hasHeader')
            ->with('Accept')
            ->willReturn(true);

        $request->expects(static::once())
            ->method('getHeader')
            ->with('Accept')
            ->willReturn('application/json;q=1');

        $this->assertInstanceOf(OutputInterface::class, $subject->create($input));
    }

    /**
     * @covers ::create
     * @covers ::parseAcceptHeader
     *
     * @return void
     */
    public function testCreateNoAccept(): void
    {
        $subject = new OutputFactory();

        $input = $this->createMock(InputInterface::class);
        $request = $this->createMock(RequestInterface::class);

        $input->expects(static::once())
            ->method('getRequest')
            ->willReturn($request);

        $request->expects(static::once())
            ->method('hasHeader')
            ->with('Accept')
            ->willReturn(false);

        $this->assertInstanceOf(OutputInterface::class, $subject->create($input));
    }
}
