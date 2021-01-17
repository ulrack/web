<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Common\Endpoint;

use GrizzIt\Http\Common\Request\RequestInterface;

interface InputInterface
{
    /**
     * Retrieves the request object.
     *
     * @return RequestInterface
     */
    public function getRequest(): RequestInterface;

    /**
     * Checks whether a parameter is set.
     *
     * @param string $key
     *
     * @return bool
     */
    public function hasParameter(string $key): bool;

    /**
     * Retrieves a parameter based on the key.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function getParameter(string $key);

    /**
     * Retrieves all parameters.
     *
     * @return array
     */
    public function getParameters(): array;

    /**
     * Sets a parameter.
     *
     * @param string $key
     * @param mixed $value
     *
     * @return void
     */
    public function setParameter(string $key, $value): void;

    /**
     * Retrieves a list of keys of available parameters.
     *
     * @return string[]
     */
    public function getParameterKeys(): array;
}
