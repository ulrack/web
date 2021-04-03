<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Common\Endpoint;

interface OutputInterface
{
    /**
     * Retrieves the output.
     *
     * @return mixed
     */
    public function getOutput(): mixed;

    /**
     * Sets the value of the output.
     *
     * @param mixed $output
     *
     * @return void
     */
    public function setOutput(mixed $output): void;

    /**
     * Sets the serving protocol.
     *
     * @param string $protocol
     *
     * @return void
     */
    public function setProtocol(string $protocol): void;

    /**
     * Retrieves current serving protocol.
     *
     * @return string
     */
    public function getProtocol(): string;

    /**
     * Sets the status code for the output.
     *
     * @param int $code
     *
     * @return void
     */
    public function setStatusCode(int $code): void;

    /**
     * Retrieves the current status code.
     *
     * @return int
     */
    public function getStatusCode(): int;

    /**
     * Retrieves a list of header keys.
     *
     * @return string[]
     */
    public function getHeaderKeys(): array;

    /**
     * Retrieves the header.
     *
     * @param string $key
     *
     * @return string
     */
    public function getHeader(string $key): string;

    /**
     * Sets a header for the response.
     *
     * @param string $key
     * @param string|null $value
     *
     * @return void
     */
    public function setHeader(string $key, ?string $value): void;

    /**
     * Checks whether a header is set for the output.
     *
     * @param string $key
     *
     * @return bool
     */
    public function hasHeader(string $key): bool;

    /**
     * Retrieves a list of accepted content types for the response.
     *
     * @return string[]
     */
    public function getAcceptedContentTypes(): array;

    /**
     * Retrieves the content type for the output.
     *
     * @return string
     */
    public function getContentType(): string;

    /**
     * Sets the content type for the output.
     *
     * @param string $mimeType
     *
     * @return void
     */
    public function setContentType(string $mimeType): void;

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
