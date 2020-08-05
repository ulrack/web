<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Tests\Component\Error;

use PHPUnit\Framework\TestCase;
use Ulrack\Web\Common\Error\ErrorInterface;
use Ulrack\Web\Component\Error\ErrorRegistry;

/**
 * @coversDefaultClass \Ulrack\Web\Component\Error\ErrorRegistry
 */
class ErrorRegistryTest extends TestCase
{
    /**
     * @covers ::setError
     * @covers ::getError
     * @covers ::hasError
     * @covers ::__construct
     *
     * @return void
     */
    public function testErrorRegistry(): void
    {
        $subject = new ErrorRegistry([]);
        $code = 404;

        $this->assertEquals(false, $subject->hasError($code));

        $error = $this->createMock(ErrorInterface::class);
        $subject->setError($code, $error);

        $this->assertEquals(true, $subject->hasError($code));

        $this->assertSame($error, $subject->getError($code));
    }
}
