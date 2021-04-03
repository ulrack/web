<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Exception;

use Exception;
use Throwable;

class HttpException extends Exception
{
    /**
     * Contains the HTTP error code.
     *
     * @var int
     */
    private int $errorCode;

    /**
     * Constructor.
     *
     * @param int $errorCode
     * @param string $message
     * @param int $code
     * @param Throwable $previous
     */
    public function __construct(
        int $errorCode,
        string $message = '',
        int $code = 0,
        Throwable $previous = null
    ) {
        $this->errorCode = $errorCode;
        parent::__construct($message, $code, $previous);
    }

    /**
     * Retrieves the HTTP specific error code.
     *
     * @return int
     */
    public function getErrorCode(): int
    {
        return $this->errorCode;
    }
}
