<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Tests\Component\Router;

use Throwable;
use PHPUnit\Framework\TestCase;
use Ulrack\Web\Component\Router\Router;
use Ulrack\Web\Common\Router\RouteInterface;
use GrizzIt\Http\Common\Request\UriInterface;
use Ulrack\Web\Common\Endpoint\InputInterface;
use Ulrack\Web\Common\Endpoint\OutputInterface;
use GrizzIt\Http\Common\Request\RequestInterface;
use Ulrack\Web\Common\Endpoint\EndpointInterface;
use Ulrack\Web\Common\Error\ErrorHandlerInterface;
use Ulrack\Web\Common\Router\PathMatcherInterface;
use Ulrack\Services\Common\ServiceFactoryInterface;
use Ulrack\Web\Common\Error\ErrorRegistryInterface;
use Ulrack\Web\Common\Output\OutputHandlerInterface;
use Ulrack\Web\Common\Request\AuthorizationHandlerInterface;

/**
 * @coversDefaultClass \Ulrack\Web\Component\Router\Router
 * @covers \Ulrack\Web\Exception\NotFoundException
 * @covers \Ulrack\Web\Exception\MethodNotAllowedException
 * @covers \Ulrack\Web\Exception\UnauthorizedException
 * @covers \Ulrack\Web\Exception\HttpException
 */
class RouterTest extends TestCase
{
    /**
     * @covers ::__invoke
     * @covers ::__construct
     * @covers ::executeRoute
     * @covers ::setParameters
     * @covers ::preExecutionChecks
     *
     * @param bool $throws
     * @param string $path
     * @param array $matchInfo
     * @param string $requestMethod
     * @param array $allowedMethods
     * @param bool $authPass
     * @param string $endpointClass
     *
     * @return void
     *
     * @dataProvider routerProvider
     */
    public function testInvoke(
        bool $throws,
        string $path,
        array $matchInfo,
        string $requestMethod,
        array $allowedMethods,
        bool $authPass,
        string $endpointClass,
        array $subRoutes
    ): void {
        $errorHandler = $this->createMock(ErrorHandlerInterface::class);
        $outputHandler = $this->createMock(OutputHandlerInterface::class);
        $serviceFactory = $this->createMock(ServiceFactoryInterface::class);
        $authorizationHandler = $this->createMock(AuthorizationHandlerInterface::class);
        $route = $this->createMock(RouteInterface::class);
        $pathMatcher = $this->createMock(PathMatcherInterface::class);
        $request = $this->createMock(RequestInterface::class);
        $uri = $this->createMock(UriInterface::class);
        $subject = new Router(
            $errorHandler,
            $outputHandler,
            $serviceFactory,
            $authorizationHandler,
            $route,
            $pathMatcher
        );

        $input = $this->createMock(InputInterface::class);
        $output = $this->createMock(OutputInterface::class);

        $input->method('getRequest')
            ->willReturn($request);

        $request->expects(static::once())
            ->method('getUri')
            ->willReturn($uri);

        $uri->expects(static::once())
            ->method('getPath')
            ->willReturn($path);

        $pathMatcher->method('__invoke')
            ->willReturnOnConsecutiveCalls(...$matchInfo);

        $route->method('getOutputHandlerService')
            ->willReturn('foo');

        $route->method('getErrorRegistryService')
            ->willReturn('bar');

        $route->method('getService')
            ->willReturn('baz');

        $serviceFactory->method('create')
            ->withConsecutive(['foo'], ['bar'], ['baz'])
            ->willReturnOnConsecutiveCalls(
                $this->createMock(OutputHandlerInterface::class),
                $this->createMock(ErrorRegistryInterface::class),
                $this->createMock($endpointClass)
            );

        $route->method('getAuthorizations')
            ->willReturn(['baz']);

        $authorizationHandler->method('pass')
            ->with(['baz'], $input, $output)
            ->willReturn($authPass);

        $request->method('getMethod')
            ->willReturn($requestMethod);

        $route->method('getMethods')
            ->willReturn($allowedMethods);

        $route->method('getRoutes')
            ->willReturn($subRoutes);

        if ($throws) {
            $this->expectException(Throwable::class);
        }

        $subject->__invoke($input, $output);
    }

    /**
     * @return array
     */
    public function routerProvider(): array
    {
        return [
            [
                true,
                '/',
                [
                    null
                ],
                'GET',
                ['GET'],
                false,
                EndpointInterface::class,
                []
            ],
            [
                true,
                '/',
                [
                    [
                    'path' => '',
                    'parameters' => []
                    ]
                ],
                'GET',
                ['POST'],
                false,
                EndpointInterface::class,
                []
            ],
            [
                true,
                '/',
                [
                    [
                        'path' => '',
                        'parameters' => []
                    ]
                ],
                'GET',
                ['GET'],
                false,
                EndpointInterface::class,
                []
            ],
            [
                true,
                '/',
                [
                    [
                    'path' => '',
                    'parameters' => []
                    ]
                ],
                'GET',
                ['GET'],
                true,
                RouteInterface::class,
                []
            ],
            [
                true,
                'foo/1',
                [
                    [
                        'path' => 'foo',
                        'parameters' => [
                            'param1' => '1'
                        ]
                    ]
                ],
                'GET',
                ['GET'],
                true,
                EndpointInterface::class,
                []
            ],
            [
                false,
                'foo/1',
                [
                    [
                        'path' => '',
                        'parameters' => [
                            'param1' => '1'
                        ]
                    ]
                ],
                'GET',
                ['GET'],
                true,
                EndpointInterface::class,
                []
            ],
            [
                true,
                'foo/1',
                [
                    [
                        'path' => 'foo',
                        'parameters' => [
                            'param1' => '1'
                        ]
                    ],
                    null
                ],
                'GET',
                ['GET'],
                true,
                EndpointInterface::class,
                [$this->createMock(RouteInterface::class)]
            ]
        ];
    }
}
