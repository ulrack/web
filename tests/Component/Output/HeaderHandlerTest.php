<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Tests\Component\Output;

use PHPUnit\Framework\TestCase;
use Ulrack\Web\Common\Endpoint\InputInterface;
use Ulrack\Web\Component\Output\HeaderHandler;
use Ulrack\Web\Common\Endpoint\OutputInterface;
use GrizzIt\Http\Common\Request\RequestInterface;

/**
 * @coversDefaultClass \Ulrack\Web\Component\Output\HeaderHandler
 */
class HeaderHandlerTest extends TestCase
{
    /**
     * @covers ::__invoke
     *
     * @return void
     *
     * @runInSeparateProcess
     */
    public function testInvoke(): void
    {
        $subject = new HeaderHandler();

        $input = $this->createMock(InputInterface::class);
        $output = $this->createMock(OutputInterface::class);
        $request = $this->createMock(RequestInterface::class);

        $input->expects(static::once())
            ->method('getRequest')
            ->willReturn($request);

        $request->expects(static::once())
            ->method('getServerVariable')
            ->with('SERVER_PROTOCOL')
            ->willReturn('HTTP/2.0');

        $output->expects(static::once())
            ->method('getStatusCode')
            ->wilLReturn(200);

        $output->expects(static::once())
            ->method('getHeaderKeys')
            ->willReturn(['Foo', 'Bar', 'Content-Type']);

        $output->expects(static::exactly(3))
            ->method('hasHeader')
            ->withConsecutive(['Foo'], ['Bar'], ['Content-Type'])
            ->willReturn(true);

        $output->expects(static::exactly(2))
            ->method('getHeader')
            ->withConsecutive(['Foo'], ['Bar'])
            ->willReturnOnConsecutiveCalls('Baz', 'Qux');

        $output->expects(static::once())
            ->method('getContentType')
            ->willReturn('application/json');

        $subject->__invoke($input, $output);

        $this->assertEquals(
            [
                'Foo: Baz',
                'Bar: Qux',
                'Content-Type: application/json'
            ],
            xdebug_get_headers()
        );
    }
}
