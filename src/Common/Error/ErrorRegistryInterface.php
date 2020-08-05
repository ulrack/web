<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Common\Error;

interface ErrorRegistryInterface
{
    /**
     * Sets up an error for a code.
     *
     * @param int $code
     * @param ErrorInterface $error
     *
     * @return void
     */
    public function setError(int $code, ErrorInterface $error): void;

    /**
     * Retrieves the error by the response code.
     *
     * @param int $code
     *
     * @return ErrorInterface
     */
    public function getError(int $code): ErrorInterface;

    /**
     * Checks whether the error is configured.
     *
     * @param int $code
     *
     * @return bool
     */
    public function hasError(int $code): bool;
}
