<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Tests\Component\Router;

use PHPUnit\Framework\TestCase;
use Ulrack\Web\Exception\HttpException;
use Ulrack\Web\Common\Router\RouteInterface;
use Ulrack\Web\Component\Router\GroupRouter;
use GrizzIt\Http\Common\Request\UriInterface;
use Ulrack\Web\Common\Endpoint\InputInterface;
use Ulrack\Web\Common\Endpoint\OutputInterface;
use GrizzIt\Http\Common\Request\RequestInterface;
use Ulrack\Web\Common\Endpoint\EndpointInterface;
use Ulrack\Web\Common\Router\RouteGroupInterface;
use Ulrack\Web\Common\Error\ErrorHandlerInterface;
use Ulrack\Web\Common\Router\PathMatcherInterface;
use Ulrack\Services\Common\ServiceFactoryInterface;
use Ulrack\Web\Common\Error\ErrorRegistryInterface;
use Ulrack\Web\Common\Output\OutputHandlerInterface;
use Ulrack\Web\Common\Request\AuthorizationHandlerInterface;

/**
 * @coversDefaultClass \Ulrack\Web\Component\Router\GroupRouter
 */
class GroupRouterTest extends TestCase
{
    /**
     * @covers ::__invoke
     * @covers ::__construct
     *
     * @param bool $throws
     * @param int $port
     * @param int[] $allowedPorts
     * @param string[] $hosts
     * @param string $requestHost
     * @param bool $authorized
     *
     * @return void
     *
     * @dataProvider routeProvider
     */
    public function testInvoke(
        bool $throws,
        int $port,
        array $allowedPorts,
        array $hosts,
        string $requestHost,
        bool $authorized
    ): void {
        $errorHandler = $this->createMock(ErrorHandlerInterface::class);
        $outputHandler = $this->createMock(OutputHandlerInterface::class);
        $serviceFactory = $this->createMock(ServiceFactoryInterface::class);
        $authorizationHandler = $this->createMock(AuthorizationHandlerInterface::class);
        $pathMatcher = $this->createMock(PathMatcherInterface::class);
        $request = $this->createMock(RequestInterface::class);
        $uri = $this->createMock(UriInterface::class);
        $routeGroup = $this->createMock(RouteGroupInterface::class);
        $subject = new GroupRouter(
            $errorHandler,
            $outputHandler,
            $serviceFactory,
            $authorizationHandler,
            $pathMatcher,
            $routeGroup
        );

        $input = $this->createMock(InputInterface::class);
        $output = $this->createMock(OutputInterface::class);
        $route = $this->createMock(RouteInterface::class);

        $input->method('getRequest')
            ->willReturn($request);

        $request->method('getUri')
            ->willReturn($uri);

        $request->method('getMethod')
            ->willReturn('GET');

        $route->method('getMethods')
            ->willReturn(['GET']);

        $uri->expects(static::once())
            ->method('getPort')
            ->willReturn($port);

        $routeGroup->expects(static::once())
            ->method('getPorts')
            ->willReturn($allowedPorts);

        $routeGroup->method('getHosts')
            ->willReturn($hosts);

        $uri->method('getHost')
            ->willReturn($requestHost);

        $routeGroup->method('getErrorRegistryService')
            ->willReturn('error.registry.service');

        $serviceFactory->method('create')
            ->withConsecutive(['error.registry.service'], [''])
            ->willReturnOnConsecutiveCalls(
                $this->createMock(ErrorRegistryInterface::class),
                $this->createMock(EndpointInterface::class),
            );

        $routeGroup->method('getAuthorizations')
            ->willReturn(['foo']);

        $authorizationHandler->method('pass')
            ->withConsecutive([['foo'], $input, $output], [[], $input, $output])
            ->willReturn($authorized);

        $routeGroup->method('getRoute')
            ->willReturn($route);

        $uri->method('getPath')
            ->willReturn('');

        $pathMatcher->method('__invoke')
            ->with($route, '/')
            ->willReturn(
                [
                    'path' => '',
                    'parameters' => []
                ]
            );

        if ($throws) {
            $this->expectException(HttpException::class);
        }

        $subject->__invoke($input, $output);
    }

    /**
     * @return array
     */
    public function routeProvider(): array
    {
        return [
            [
                true,
                80,
                [443],
                [
                    'example.com'
                ],
                '',
                false
            ],
            [
                true,
                80,
                [80, 443],
                [
                    'example.com'
                ],
                '',
                false
            ],
            [
                true,
                80,
                [80, 443],
                [
                    '*.example.com'
                ],
                'test.example.com',
                false
            ],
            [
                false,
                80,
                [80, 443],
                [
                    '*.example.com'
                ],
                'test.example.com',
                true
            ]
        ];
    }
}
