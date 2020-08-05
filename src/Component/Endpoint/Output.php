<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Component\Endpoint;

use Ulrack\Web\Common\Endpoint\OutputInterface;

class Output implements OutputInterface
{
    /**
     * Contains the serving protocol.
     *
     * @var string
     */
    private $protocol;

    /**
     * Contains the status code for the response.
     *
     * @var int
     */
    private $statusCode = 200;

    /**
     * Contains the headers for the response.
     *
     * @var string[]
     */
    private $headers = [];

    /**
     * Contains the parameters.
     *
     * @var array
     */
    private $parameters = [];

    /**
     * Contains the chosen content type.
     *
     * @var string
     */
    private $contentType = '';

    /**
     * Contains the output of the response.
     *
     * @var mixed
     */
    private $output;

    /**
     * Contains the accepted content types.
     *
     * @var string[]
     */
    private $acceptedContentTypes;

    /**
     * Constructor.
     *
     * @param string ...$acceptedContentTypes
     */
    public function __construct(string ...$acceptedContentTypes)
    {
        $this->acceptedContentTypes = $acceptedContentTypes;
        if (count($acceptedContentTypes) > 0) {
            $this->contentType = $acceptedContentTypes[0];
        }
    }

    /**
     * Retrieves the output.
     *
     * @return mixed
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * Sets the value of the output.
     *
     * @param mixed $output
     *
     * @return void
     */
    public function setOutput($output): void
    {
        $this->output = $output;
    }

    /**
     * Sets the serving protocol.
     *
     * @param string $protocol
     *
     * @return void
     */
    public function setProtocol(string $protocol): void
    {
        $this->protocol = $protocol;
    }

    /**
     * Retrieves current serving protocol.
     *
     * @return string
     */
    public function getProtocol(): string
    {
        return $this->protocol;
    }

    /**
     * Sets the status code for the output.
     *
     * @param int $code
     *
     * @return void
     */
    public function setStatusCode(int $code): void
    {
        $this->statusCode = $code;
    }

    /**
     * Retrieves the current status code.
     *
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * Retrieves a list of header keys.
     *
     * @return string[]
     */
    public function getHeaderKeys(): array
    {
        return array_keys($this->headers);
    }

    /**
     * Retrieves the header.
     *
     * @param string $key
     *
     * @return string
     */
    public function getHeader(string $key): string
    {
        return $this->headers[$key];
    }

    /**
     * Sets a header for the response.
     *
     * @param string $key
     * @param string|null $value
     *
     * @return void
     */
    public function setHeader(string $key, ?string $value): void
    {
        $this->headers[$key] = $value;
    }

    /**
     * Checks whether a header is set for the output.
     *
     * @param string $key
     *
     * @return bool
     */
    public function hasHeader(string $key): bool
    {
        return isset($this->headers[$key]);
    }

    /**
     * Retrieves a list of accepted content types for the response.
     *
     * @return string[]
     */
    public function getAcceptedContentTypes(): array
    {
        return $this->acceptedContentTypes;
    }

    /**
     * Retrieves the content type for the output.
     *
     * @return string
     */
    public function getContentType(): string
    {
        return $this->contentType;
    }

    /**
     * Sets the content type for the output.
     *
     * @param string $mimeType
     *
     * @return void
     */
    public function setContentType(string $mimeType): void
    {
        $this->contentType = $mimeType;
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
