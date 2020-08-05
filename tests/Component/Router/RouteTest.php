<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Tests\Component\Router;

use PHPUnit\Framework\TestCase;
use Ulrack\Web\Component\Router\Route;
use Ulrack\Web\Common\Router\RouteInterface;

/**
 * @coversDefaultClass \Ulrack\Web\Component\Router\Route
 */
class RouteTest extends TestCase
{
    /**
     * @covers ::getPath
     * @covers ::getService
     * @covers ::getRoutes
     * @covers ::addRoute
     * @covers ::getOutputHandlerService
     * @covers ::getMethods
     * @covers ::getErrorRegistryService
     * @covers ::addAuthorization
     * @covers ::getAuthorizations
     * @covers ::__construct
     *
     * @return void
     */
    public function testGetPath(): void
    {
        $path = 'path';
        $service = 'service';
        $methods = ['GET'];
        $outputService = 'output.service';
        $errorRegistryService = 'error.registry.service';
        $route = $this->createMock(RouteInterface::class);
        $subject = new Route(
            $path,
            $service,
            $methods,
            $outputService,
            $errorRegistryService,
            $route
        );

        $subject->addRoute($route);

        $this->assertEquals($path, $subject->getPath());
        $this->assertEquals($service, $subject->getService());
        $this->assertEquals([$route, $route], $subject->getRoutes());
        $this->assertEquals(
            $outputService,
            $subject->getOutputHandlerService()
        );

        $this->assertEquals(['GET'], $subject->getMethods());
        $this->assertEquals(
            $errorRegistryService,
            $subject->getErrorRegistryService()
        );

        $this->assertEquals(
            $errorRegistryService,
            $subject->getErrorRegistryService()
        );

        $subject->addAuthorization('foo');

        $this->assertEquals(['foo'], $subject->getAuthorizations());
    }
}
