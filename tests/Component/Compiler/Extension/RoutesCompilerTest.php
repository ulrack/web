<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Tests\Component\Compiler\Extension;

use RuntimeException;
use PHPUnit\Framework\TestCase;
use Ulrack\Services\Common\ServiceRegistryInterface;
use GrizzIt\Validator\Component\Logical\AlwaysValidator;
use Ulrack\Web\Component\Compiler\Extension\RoutesCompiler;

/**
 * @coversDefaultClass \Ulrack\Web\Component\Compiler\Extension\RoutesCompiler
 */
class RoutesCompilerTest extends TestCase
{
    /**
     * @covers ::compile
     * @covers ::compileRoutes
     * @covers ::isRouteReferenced
     * @covers ::__construct
     *
     * @return void
     */
    public function testCompile(): void
    {
        $subject = new RoutesCompiler(
            $this->createMock(ServiceRegistryInterface::class),
            'routes',
            new AlwaysValidator(true),
            [],
            (function () {
                return [];
            })
        );

        $services = ['routes' => [
            'foo' => [
                'path' => '/',
                'service' => 'services.foo',
                'methods' => ['GET'],
                'outputService' => 'services.outputService',
                'errorRegistryService' => 'services.errorRegistryService',
                'authorizationServices' => ['services.authorizationServices'],
                'weight' => 100
            ],
            'bar' => [
                'path' => '/bar',
                'service' => 'services.bar',
                'methods' => ['GET'],
                'outputService' => 'services.outputService',
                'errorRegistryService' => 'services.errorRegistryService',
                'authorizationServices' => ['services.authorizationServices'],
                'weight' => 100,
                'parent' => 'foo'
            ]
        ]];

        $this->assertEquals([
            'routes' => [
                'foo' => [
                    'path' => '/',
                    'service' => 'services.foo',
                    'methods' => ['GET'],
                    'outputService' => 'services.outputService',
                    'errorRegistryService' => 'services.errorRegistryService',
                    'authorizationServices' => ['services.authorizationServices'],
                    'routes' => ['bar']
                ],
                'bar' => [
                    'path' => '/bar',
                    'service' => 'services.bar',
                    'methods' => ['GET'],
                    'outputService' => 'services.outputService',
                    'errorRegistryService' => 'services.errorRegistryService',
                    'authorizationServices' => ['services.authorizationServices'],
                    'routes' => []
                ]
            ]
        ], $subject->compile($services));
    }

    /**
     * @covers ::compile
     * @covers ::compileRoutes
     * @covers ::isRouteReferenced
     * @covers ::__construct
     *
     * @return void
     */
    public function testCompileFail(): void
    {
        $subject = new RoutesCompiler(
            $this->createMock(ServiceRegistryInterface::class),
            'routes',
            new AlwaysValidator(true),
            [],
            (function () {
                return [];
            })
        );

        $services = ['routes' => [
            'foo' => [
                'path' => '/',
                'service' => 'services.foo',
                'methods' => ['GET'],
                'outputService' => 'services.outputService',
                'errorRegistryService' => 'services.errorRegistryService',
                'authorizationServices' => ['services.authorizationServices'],
                'weight' => 100,
                'parent' => 'foo'
            ]
        ]];

        $this->expectException(RuntimeException::class);
        $subject->compile($services);
    }
}
