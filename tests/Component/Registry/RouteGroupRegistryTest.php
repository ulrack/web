<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Tests\Component\Registry;

use PHPUnit\Framework\TestCase;
use Ulrack\Web\Common\Router\RouteGroupInterface;
use Ulrack\Web\Component\Registry\RouteGroupRegistry;

/**
 * @coversDefaultClass \Ulrack\Web\Component\Registry\RouteGroupRegistry
 */
class RouteGroupRegistryTest extends TestCase
{
    /**
     * @covers ::register
     * @covers ::has
     * @covers ::get
     * @covers ::getKeys
     * @covers ::__construct
     *
     * @return void
     */
    public function testRegistry(): void
    {
        $subject = new RouteGroupRegistry();
        $routeGroup = $this->createMock(RouteGroupInterface::class);

        $this->assertEquals(false, $subject->has('foo'));
        $subject->register('foo', $routeGroup);
        $this->assertEquals(true, $subject->has('foo'));
        $this->assertEquals($routeGroup, $subject->get('foo'));
        $this->assertEquals(['foo'], $subject->getKeys());
    }
}
