<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Tests\Component\Error;

use Exception;
use PHPUnit\Framework\TestCase;
use Ulrack\Web\Common\Error\ErrorInterface;
use Ulrack\Web\Component\Error\ErrorHandler;
use Ulrack\Web\Common\Endpoint\InputInterface;
use Ulrack\Web\Common\Endpoint\OutputInterface;
use Ulrack\Web\Common\Error\ErrorRegistryInterface;
use Ulrack\Web\Exception\MethodNotAllowedException;
use Ulrack\Web\Common\Output\OutputHandlerInterface;

/**
 * @coversDefaultClass \Ulrack\Web\Component\Error\ErrorHandler
 * @covers \Ulrack\Web\Exception\MethodNotAllowedException
 * @covers \Ulrack\Web\Exception\HttpException
 */
class ErrorHandlerTest extends TestCase
{
    /**
     * @covers ::setOutputHandler
     * @covers ::setErrorRegistry
     * @covers ::outputByException
     * @covers ::outputByCode
     * @covers ::__construct
     *
     * @return void
     */
    public function testErrorHandler(): void
    {
        $input = $this->createMock(InputInterface::class);
        $output = $this->createMock(OutputInterface::class);
        $outputHandler = $this->createMock(OutputHandlerInterface::class);
        $errorRegistry = $this->createMock(ErrorRegistryInterface::class);
        $subject = new ErrorHandler($input, $output, $outputHandler, $errorRegistry);

        $error = $this->createMock(ErrorInterface::class);
        $errorRegistry->expects(static::exactly(2))
            ->method('getError')
            ->withConsecutive([404], [500])
            ->willReturnOnConsecutiveCalls(
                new Exception(),
                $this->returnValue($error)
            );

        $error->expects(static::once())
            ->method('__invoke')
            ->with($input, $output);

        $outputHandler->expects(static::once())
            ->method('__invoke')
            ->with($input, $output);

        $subject->outputByCode(404);

        $newOutputHandler = $this->createMock(OutputHandlerInterface::class);
        $subject->setOutputHandler($newOutputHandler);

        $newErrorRegistry = $this->createMock(ErrorRegistryInterface::class);
        $subject->setErrorRegistry($newErrorRegistry);

        $exception = new MethodNotAllowedException();

        $input->expects(static::once())
            ->method('setParameter')
            ->with('exception', $exception);

        $subject->outputByException($exception);
    }
}
