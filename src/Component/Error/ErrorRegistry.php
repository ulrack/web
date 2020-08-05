<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Component\Error;

use Ulrack\Web\Common\Error\ErrorInterface;
use Ulrack\Web\Common\Error\ErrorRegistryInterface;

class ErrorRegistry implements ErrorRegistryInterface
{
    /**
     * Contains the configured errors.
     *
     * @var ErrorInterface[]
     */
    private $errors;

    /**
     * Constructor.
     *
     * @param ErrorInterface[] $errors
     */
    public function __construct(array $errors = [])
    {
        $this->errors = $errors;
    }

    /**
     * Sets up an error for a code.
     *
     * @param int $code
     * @param ErrorInterface $error
     *
     * @return void
     */
    public function setError(int $code, ErrorInterface $error): void
    {
        $this->errors[$code] = $error;
    }

    /**
     * Retrieves the error by the response code.
     *
     * @param int $code
     *
     * @return ErrorInterface
     */
    public function getError(int $code): ErrorInterface
    {
        return $this->errors[$code];
    }

    /**
     * Checks whether the error is configured.
     *
     * @param int $code
     *
     * @return bool
     */
    public function hasError(int $code): bool
    {
        return isset($this->errors[$code]);
    }
}
