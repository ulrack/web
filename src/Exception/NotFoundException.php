<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Exception;

use Throwable;

class NotFoundException extends HttpException
{
    /**
     * Constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable $previous
     */
    public function __construct(
        string $message = '',
        int $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct(404, $message, $code, $previous);
    }
}
