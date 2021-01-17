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
use Ulrack\Web\Component\Middleware\PathMatchingMiddleware;

/**
 * @coversDefaultClass \Ulrack\Web\Component\Middleware\PathMatchingMiddleware
 */
class PathMatchingMiddlewareTest extends TestCase
{
    /**
     * @param string $route
     * @param string $path
     * @param bool $expected
     *
     * @return void
     *
     * @covers ::__construct
     * @covers ::getErrorCode
     * @covers ::getParameters
     * @covers ::pass
     *
     * @dataProvider componentDataProvider
     */
    public function testComponent(
        string $route,
        string $path,
        bool $expected
    ): void {
        $subject = new PathMatchingMiddleware($route);
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
            ->method('getPath')
            ->willReturn($path);

        $this->assertEquals($expected, $subject->pass($input, $output));
    }

    /**
     * @return array
     */
    public function componentDataProvider(): array
    {
        return [
            [
                'users/{user}',
                'users/1',
                true
            ],
            [
                'users',
                'users',
                true
            ],
            [
                'users/user',
                'users',
                false
            ]
            ,
            [
                'users/{user}',
                '1/users',
                false
            ]
        ];
    }
}
