<?php

namespace Ulrack\Web\Tests\Factory\Extension;

use PHPUnit\Framework\TestCase;
use Ulrack\Web\Common\Router\RouteInterface;
use Ulrack\Web\Factory\Extension\RoutesFactory;
use Ulrack\Services\Common\ServiceFactoryInterface;
use Ulrack\Services\Exception\DefinitionNotFoundException;

/**
 * @coversDefaultClass \Ulrack\Web\Factory\Extension\RoutesFactory
 */
class RoutesFactoryTest extends TestCase
{
    /**
     * @covers ::registerService
     * @covers ::createFromArray
     * @covers ::createRoute
     * @covers ::create
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
            'routes' => [
                'foo' => [
                    'path' => '/',
                    'service' => 'services.foo',
                    'methods' => ['GET'],
                    'outputService' => 'services.outputService',
                    'errorRegistryService' => 'services.errorRegistryService',
                    'authorizationServices' => ['services.authorizationServices'],
                    'routes' => ['routes.bar']
                ]
            ]
        ];

        $subject = new RoutesFactory(
            $serviceFactory,
            'routes',
            [],
            $services,
            (function () {
                return [];
            }),
            []
        );

        $serviceKey = 'routes.foo';

        $return = $subject->create($serviceKey);
        $this->assertInstanceOf(RouteInterface::class, $return);
        $this->assertSame($return, $subject->create($serviceKey));
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
            'routes' => [
                'foo' => [
                    'path' => '/',
                    'service' => 'services.foo',
                    'methods' => ['GET'],
                    'outputService' => 'services.outputService',
                    'errorRegistryService' => 'services.errorRegistryService',
                    'authorizationServices' => ['services.authorizationServices'],
                    'routes' => ['routes.bar']
                ]
            ]
        ];

        $subject = new RoutesFactory(
            $serviceFactory,
            'routes',
            [],
            $services,
            (function () {
                return [];
            }),
            []
        );

        $serviceKey = 'routes.bar';
        $this->expectException(DefinitionNotFoundException::class);
        $subject->create($serviceKey);
    }
}
