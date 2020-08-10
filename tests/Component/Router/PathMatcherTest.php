<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Tests\Component\Router;

use PHPUnit\Framework\TestCase;
use Ulrack\Web\Common\Router\RouteInterface;
use Ulrack\Web\Component\Router\PathMatcher;

/**
 * @coversDefaultClass \Ulrack\Web\Component\Router\PathMatcher
 */
class PathMatcherTest extends TestCase
{
    /**
     * @covers ::__invoke
     * @covers ::stripPath
     *
     * @param string $routePath
     * @param string $path
     * @param array|null $result
     *
     * @return void
     *
     * @dataProvider routeDataProvider
     */
    public function testInvoke(
        string $routePath,
        string $path,
        ?array $result
    ): void {
        $subject = new PathMatcher();

        $route = $this->createMock(RouteInterface::class);

        $route->expects(static::once())
            ->method('getPath')
            ->willReturn($routePath);

        $this->assertEquals($result, $subject->__invoke($route, $path));
    }

    /**
     * @return array
     */
    public function routeDataProvider(): array
    {
        return [
            [
                '',
                'foo',
                [
                    'path' => 'foo',
                    'parameters' => []
                ]
            ],
            [
                '/foo/bar/baz/1/',
                'foo/bar/baz/1',
                [
                    'path' => '',
                    'parameters' => []
                ]
            ],
            [
                'foo/bar/baz/1',
                'foo/bar/baz/1',
                [
                    'path' => '',
                    'parameters' => []
                ]
            ],
            [
                'foo/bar/baz/1/foo',
                'foo/bar/baz/1',
                null
            ],
            [
                'foo/bar/baz/{param1}',
                'foo/bar/baz/1',
                [
                    'path' => '',
                    'parameters' => [
                        'param1' => 1
                    ]
                ]
            ],
            [
                'foo/bar/{param1}/foo',
                'foo/bar/baz/1',
                null
            ],
            [
                'foo/bar/baz/{param1}/{param2}',
                'foo/bar/baz/1',
                null
            ]
        ];
    }
}
