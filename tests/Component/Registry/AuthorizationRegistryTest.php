<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Tests\Component\Registry;

use PHPUnit\Framework\TestCase;
use Ulrack\Web\Component\Registry\AuthorizationRegistry;

/**
 * @coversDefaultClass \Ulrack\Web\Component\Registry\AuthorizationRegistry
 */
class AuthorizationRegistryTest extends TestCase
{
    /**
     * @covers ::register
     * @covers ::has
     * @covers ::get
     * @covers ::toArray
     * @covers ::__construct
     *
     * @return void
     */
    public function testRegistry(): void
    {
        $subject = new AuthorizationRegistry();

        $this->assertEquals(false, $subject->has('foo'));
        $subject->register('foo', 'bar');
        $this->assertEquals(true, $subject->has('foo'));
        $this->assertEquals('bar', $subject->get('foo'));
        $this->assertEquals(['foo' => 'bar'], $subject->toArray());
    }
}
