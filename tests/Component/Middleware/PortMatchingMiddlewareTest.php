<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Tests\Component\Endpoint;

use PHPUnit\Framework\TestCase;
use GrizzIt\Http\Common\Request\UriInterface;
use Ulrack\Web\Common\Endpoint\InputInterface;
use Ulrack\Web\Common\Endpoint\OutputInterface;
use GrizzIt\Http\Common\Request\RequestInterface;
use Ulrack\Web\Component\Middleware\PortMatchingMiddleware;

/**
 * @coversDefaultClass \Ulrack\Web\Component\Middleware\PortMatchingMiddleware
 */
class PortMatchingMiddlewareTest extends TestCase
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
        $subject = new PortMatchingMiddleware(80, 443);
        $this->assertEquals(404, $subject->getErrorCode());
        $input = $this->createMock(InputInterface::class);
        $output = $this->createMock(OutputInterface::class);
        $request = $this->createMock(RequestInterface::class);
        $uri = $this->createMock(UriInterface::class);

        $input->expects(static::once())
            ->method('getRequest')
            ->willReturn($request);

        $request->expects(static::once())
            ->method('getUri')
            ->willReturn($uri);

        $uri->expects(static::once())
            ->method('getPort')
            ->willReturn(80);

        $this->assertEquals(true, $subject->pass($input, $output));
    }
}
