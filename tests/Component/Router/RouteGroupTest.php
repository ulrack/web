<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Tests\Component\Router;

use PHPUnit\Framework\TestCase;
use Ulrack\Web\Component\Router\RouteGroup;
use Ulrack\Web\Common\Router\RouteInterface;

/**
 * @coversDefaultClass \Ulrack\Web\Component\Router\RouteGroup
 */
class RouteGroupTest extends TestCase
{
    /**
     * @covers ::getPorts
     * @covers ::getHosts
     * @covers ::getRoute
     * @covers ::getErrorRegistryService
     * @covers ::addAuthorization
     * @covers ::getAuthorizations
     * @covers ::__construct
     *
     * @return void
     */
    public function testGetPorts(): void
    {
        $ports = [80, 443];
        $hosts = ['example.com'];
        $route = $this->createMock(RouteInterface::class);
        $errorRegistryService = 'error.registry.service';
        $subject = new RouteGroup(
            $ports,
            $hosts,
            $route,
            $errorRegistryService
        );

        $this->assertEquals($ports, $subject->getPorts());
        $this->assertEquals($hosts, $subject->getHosts());
        $this->assertEquals($route, $subject->getRoute());
        $this->assertEquals(
            $errorRegistryService,
            $subject->getErrorRegistryService()
        );

        $subject->addAuthorization('foo');
        $this->assertEquals(['foo'], $subject->getAuthorizations());
    }
}
