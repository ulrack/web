<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Component\Endpoint;

use Ulrack\Web\Common\Endpoint\InputInterface;
use GrizzIt\Http\Common\Request\RequestInterface;

class Input implements InputInterface
{
    /**
     * Contains the request.
     *
     * @var RequestInterface
     */
    private $request;

    /**
     * Contains the parameters for the input.
     *
     * @var array
     */
    private $parameters = [];

    /**
     * Constructor.
     *
     * @param RequestInterface $request
     */
    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }

    /**
     * Retrieves the request object.
     *
     * @return RequestInterface
     */
    public function getRequest(): RequestInterface
    {
        return $this->request;
    }

    /**
     * Checks whether a parameter is set.
     *
     * @param string $key
     *
     * @return bool
     */
    public function hasParameter(string $key): bool
    {
        return isset($this->parameters[$key]);
    }

    /**
     * Retrieves a parameter based on the key.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function getParameter(string $key)
    {
        return $this->parameters[$key];
    }

    /**
     * Retrieves all parameters.
     *
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * Sets a parameter.
     *
     * @param string $key
     * @param mixed $value
     *
     * @return void
     */
    public function setParameter(string $key, $value): void
    {
        $this->parameters[$key] = $value;
    }

    /**
     * Retrieves a list of keys of available parameters.
     *
     * @return string[]
     */
    public function getParameterKeys(): array
    {
        return array_keys($this->parameters);
    }
}
