<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Tests\Component\Endpoint;

use PHPUnit\Framework\TestCase;
use Ulrack\Web\Common\Endpoint\InputInterface;
use Ulrack\Web\Common\Endpoint\OutputInterface;
use GrizzIt\Http\Common\Request\RequestInterface;
use Ulrack\Web\Component\Middleware\MethodMatchingMiddleware;

/**
 * @coversDefaultClass \Ulrack\Web\Component\Middleware\MethodMatchingMiddleware
 */
class MethodMatchingMiddlewareTest extends TestCase
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
        $subject = new MethodMatchingMiddleware('GET', 'POST');
        $this->assertEquals(405, $subject->getErrorCode());
        $input = $this->createMock(InputInterface::class);
        $output = $this->createMock(OutputInterface::class);
        $request = $this->createMock(RequestInterface::class);

        $input->expects(static::once())
            ->method('getRequest')
            ->willReturn($request);

        $request->expects(static::once())
            ->method('getMethod')
            ->willReturn('GET');

        $this->assertEquals(true, $subject->pass($input, $output));
    }
}
