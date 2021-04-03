<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Component\Error;

use Throwable;
use Ulrack\Web\Exception\HttpException;
use Ulrack\Web\Common\Endpoint\InputInterface;
use Ulrack\Web\Common\Endpoint\OutputInterface;
use Ulrack\Web\Common\Error\ErrorHandlerInterface;
use Ulrack\Web\Common\Error\ErrorRegistryInterface;
use Ulrack\Web\Common\Output\OutputHandlerInterface;

class ErrorHandler implements ErrorHandlerInterface
{
    /**
     * Contains a reference to the input.
     *
     * @var InputInterface
     */
    private InputInterface $input;

    /**
     * Contains a reference to the output.
     *
     * @var OutputInterface
     */
    private OutputInterface $output;

    /**
     * Contains the output handler.
     *
     * @var OutputHandlerInterface
     */
    private OutputHandlerInterface $outputHandler;

    /**
     * Contains the error registry.
     *
     * @var ErrorRegistryInterface
     */
    private ErrorRegistryInterface $errorRegistry;

    /**
     * Constructor.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @param OutputHandlerInterface $outputHandler
     * @param ErrorRegistryInterface $errorRegistry
     */
    public function __construct(
        InputInterface $input,
        OutputInterface $output,
        OutputHandlerInterface $outputHandler,
        ErrorRegistryInterface $errorRegistry
    ) {
        $this->input = $input;
        $this->output = $output;
        $this->outputHandler = $outputHandler;
        $this->errorRegistry = $errorRegistry;
    }

    /**
     * Sets the output handler used in the error handler.
     *
     * @param OutputHandlerInterface $outputHandler
     *
     * @return void
     */
    public function setOutputHandler(
        OutputHandlerInterface $outputHandler
    ): void {
        $this->outputHandler = $outputHandler;
    }

    /**
     * Sets the error registry used in the error handling.
     *
     * @param ErrorRegistryInterface $errorRegistry
     *
     * @return void
     */
    public function setErrorRegistry(
        ErrorRegistryInterface $errorRegistry
    ): void {
        $this->errorRegistry = $errorRegistry;
    }

    /**
     * Output the error based on an exception.
     *
     * @param Throwable $exception
     *
     * @return void
     */
    public function outputByException(Throwable $exception): void
    {
        $code = 500;

        if ($exception instanceof HttpException) {
            $code = $exception->getErrorCode();
        }

        $this->input->setParameter('exception', $exception);
        $this->outputByCode($code);
    }

    /**
     * Output the error based on a code.
     *
     * @param int $code
     *
     * @return void
     */
    public function outputByCode(int $code): void
    {
        try {
            $error = $this->errorRegistry->getError($code);
        } catch (Throwable $exception) {
            $error = $this->errorRegistry->getError(500);
        }

        $error($this->input, $this->output);
        $this->outputHandler->__invoke($this->input, $this->output);
    }
}
