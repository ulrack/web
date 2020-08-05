<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Common\Error;

use Throwable;
use Ulrack\Web\Common\Error\ErrorRegistryInterface;
use Ulrack\Web\Common\Output\OutputHandlerInterface;

interface ErrorHandlerInterface
{
    /**
     * Sets the output handler used in the error handler.
     *
     * @param OutputHandlerInterface $outputHandler
     *
     * @return void
     */
    public function setOutputHandler(
        OutputHandlerInterface $outputHandler
    ): void;

    /**
     * Sets the error registry used in the error handling.
     *
     * @param ErrorRegistryInterface $errorRegistry
     *
     * @return void
     */
    public function setErrorRegistry(
        ErrorRegistryInterface $errorRegistry
    ): void;

    /**
     * Output the error based on an exception.
     *
     * @param Throwable $exception
     *
     * @return void
     */
    public function outputByException(Throwable $exception): void;

    /**
     * Output the error based on a code.
     *
     * @param int $code
     *
     * @return void
     */
    public function outputByCode(int $code): void;
}
