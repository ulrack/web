<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Tests\Component\Endpoint;

use PHPUnit\Framework\TestCase;
use Ulrack\Web\Component\Endpoint\Output;

/**
 * @coversDefaultClass \Ulrack\Web\Component\Endpoint\Output
 */
class OutputTest extends TestCase
{
    /**
     * @covers ::getOutput
     * @covers ::setOutput
     * @covers ::setProtocol
     * @covers ::getProtocol
     * @covers ::setStatusCode
     * @covers ::getStatusCode
     * @covers ::setHeader
     * @covers ::getHeaderKeys
     * @covers ::getHeader
     * @covers ::hasHeader
     * @covers ::getAcceptedContentTypes
     * @covers ::getContentType
     * @covers ::setContentType
     * @covers ::getParameterKeys
     * @covers ::setParameter
     * @covers ::hasParameter
     * @covers ::getParameter
     * @covers ::__construct
     *
     * @return void
     */
    public function testOutput(): void
    {
        $subject = new Output('application/json', 'text/html');

        $subject->setOutput('foo');
        $this->assertEquals('foo', $subject->getOutput());

        $subject->setProtocol('HTTP/2.0');
        $this->assertEquals('HTTP/2.0', $subject->getProtocol());

        $subject->setStatusCode(200);
        $this->assertEquals(200, $subject->getStatusCode());

        $subject->setHeader('Content-Language', 'en');
        $this->assertEquals(true, $subject->hasHeader('Content-Language'));
        $this->assertEquals(['Content-Language'], $subject->getHeaderKeys());
        $this->assertEquals('en', $subject->getHeader('Content-Language'));

        $this->assertEquals(
            ['application/json', 'text/html'],
            $subject->getAcceptedContentTypes()
        );

        $this->assertEquals('application/json', $subject->getContentType());
        $subject->setContentType('text/html');
        $this->assertEquals('text/html', $subject->getContentType());

        $this->assertEquals([], $subject->getParameterKeys());
        $subject->setParameter('foo', 'bar');
        $this->assertEquals(['foo'], $subject->getParameterKeys());
        $this->assertEquals(true, $subject->hasParameter('foo'));
        $this->assertEquals('bar', $subject->getParameter('foo'));
    }
}
