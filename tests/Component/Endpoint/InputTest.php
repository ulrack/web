<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Tests\Component\Endpoint;

use PHPUnit\Framework\TestCase;
use Ulrack\Web\Component\Endpoint\Input;
use GrizzIt\Http\Common\Request\RequestInterface;

/**
 * @coversDefaultClass \Ulrack\Web\Component\Endpoint\Input
 */
class InputTest extends TestCase
{
    /**
     * @covers ::getRequest
     * @covers ::__construct
     *
     * @return void
     */
    public function testGetRequest(): void
    {
        $request = $this->createMock(RequestInterface::class);
        $subject = new Input($request);

        $this->assertEquals($request, $subject->getRequest());
    }

    /**
     * @covers ::hasParameter
     * @covers ::getParameter
     * @covers ::setParameter
     * @covers ::getParameterKeys
     * @covers ::__construct
     *
     * @return void
     */
    public function testParameters(): void
    {
        $request = $this->createMock(RequestInterface::class);
        $subject = new Input($request);
        $key = 'foo';
        $value = 'bar';

        $this->assertEquals(false, $subject->hasParameter($key));
        $subject->setParameter($key, $value);
        $this->assertEquals(true, $subject->hasParameter($key));
        $this->assertEquals($value, $subject->getParameter($key));
        $this->assertEquals(['foo'], $subject->getParameterKeys());
    }
}
