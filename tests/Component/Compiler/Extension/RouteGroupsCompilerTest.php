<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Tests\Component\Compiler\Extension;

use PHPUnit\Framework\TestCase;
use Ulrack\Services\Common\ServiceRegistryInterface;
use GrizzIt\Validator\Component\Logical\AlwaysValidator;
use Ulrack\Web\Component\Compiler\Extension\RouteGroupsCompiler;

/**
 * @coversDefaultClass \Ulrack\Web\Component\Compiler\Extension\RouteGroupsCompiler
 */
class RouteGroupsCompilerTest extends TestCase
{
    /**
     * @covers ::compile
     * @covers ::compileRouteGroups
     * @covers ::__construct
     *
     * @return void
     */
    public function testCompile(): void
    {
        $subject = new RouteGroupsCompiler(
            $this->createMock(ServiceRegistryInterface::class),
            'routes-groups',
            new AlwaysValidator(true),
            [],
            (function () {
                return [];
            })
        );

        $services = [
            'route-groups' => [
                'foo-group' => [
                    'weight' => 500,
                    'ports' => [80, 443],
                    'hosts' => ['*'],
                    'route' => 'routes.foo',
                    'errorRegistryService' => 'services.errorRegistryService',
                    'authorizationServices' => ['services.authorizationServices']
                ]
            ]
        ];

        $this->assertEquals(
            [
                'route-groups' => [
                    'foo-group' => [
                        'ports' => [80, 443],
                        'hosts' => ['*'],
                        'route' => 'routes.foo',
                        'errorRegistryService' => 'services.errorRegistryService',
                        'authorizationServices' => ['services.authorizationServices']
                    ]
                ]
            ],
            $subject->compile($services)
        );
    }
}
