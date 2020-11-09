<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Tests\Factory\Extension;

use PHPUnit\Framework\TestCase;
use Ulrack\Web\Common\Router\RouteInterface;
use Ulrack\Web\Common\Router\RouteGroupInterface;
use Ulrack\Services\Common\ServiceFactoryInterface;
use Ulrack\Web\Factory\Extension\RouteGroupsFactory;
use Ulrack\Services\Exception\DefinitionNotFoundException;

/**
 * @coversDefaultClass \Ulrack\Web\Factory\Extension\RouteGroupsFactory
 */
class RouteGroupsFactoryTest extends TestCase
{
    /**
     * @covers ::create
     * @covers ::getRouteGroups
     * @covers ::registerService
     * @covers ::createRouteGroup
     * @covers ::__construct
     *
     * @return void
     */
    public function testCreate(): void
    {
        $serviceFactory = $this->createMock(ServiceFactoryInterface::class);
        $serviceFactory->expects(static::once())
            ->method('create')
            ->with('routes.bar')
            ->willReturn($this->createMock(RouteInterface::class));

        $services = [
            'route-groups' => [
                'foo' => [
                    'ports' => [80, 443],
                    'hosts' => ['*'],
                    'route' => 'routes.bar',
                    'errorRegistryService' => 'services.errorRegistryService',
                    'authorizationServices' => ['services.authorizationServices']
                ]
            ]
        ];

        $subject = new RouteGroupsFactory(
            $serviceFactory,
            'route-groups',
            [],
            $services,
            (function () {
                return [];
            }),
            []
        );

        $return = $subject->getRouteGroups();
        $this->assertInstanceOf(RouteGroupInterface::class, $return[0]);
        $this->assertSame($return, $subject->getRouteGroups());
    }

    /**
     * @covers ::create
     * @covers ::__construct
     *
     * @return void
     */
    public function testCreateFail(): void
    {
        $serviceFactory = $this->createMock(ServiceFactoryInterface::class);
        $services = [
            'route-groups' => [
                'foo' => [
                    'ports' => [80, 443],
                    'hosts' => ['*'],
                    'route' => 'routes.bar',
                    'errorRegistryService' => 'services.errorRegistryService',
                    'authorizationServices' => ['services.authorizationServices']
                ]
            ]
        ];

        $subject = new RouteGroupsFactory(
            $serviceFactory,
            'route-groups',
            [],
            $services,
            (function () {
                return [];
            }),
            []
        );

        $this->expectException(DefinitionNotFoundException::class);
        $subject->create('route-groups.bar');
    }
}
