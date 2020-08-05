<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Component\Error;

use Ulrack\Web\Common\Error\ErrorInterface;
use Ulrack\Web\Common\Output\StatusCodeEnum;
use Ulrack\Web\Common\Endpoint\InputInterface;
use Ulrack\Web\Common\Endpoint\OutputInterface;

class ConfigurableApiError implements ErrorInterface
{
    /**
     * Contains the error status code.
     *
     * @var int
     */
    private $errorStatusCode;

    /**
     * Contains the error code.
     *
     * @var int
     */
    private $errorCode;

    /**
     * Contains the error message.
     *
     * @var string
     */
    private $errorMessage;

    /**
     * Contains the default content type.
     *
     * @var string
     */
    private $defaultContentType;

    /**
     * Constructor.
     *
     * @param int $errorStatusCode
     * @param int $errorCode
     * @param string $errorMessage
     * @param string $defaultContentType
     */
    public function __construct(
        int $errorStatusCode,
        int $errorCode = null,
        string $errorMessage = null,
        string $defaultContentType = 'application/json'
    ) {
        $this->errorStatusCode = $errorStatusCode;
        $this->errorCode = $errorCode;
        $this->errorMessage = $errorMessage;
        $this->defaultContentType = $defaultContentType;
    }

    /**
     * Sets the input and output up for an error response.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return void
     */
    public function __invoke(
        InputInterface $input,
        OutputInterface $output
    ): void {
        $output->setStatusCode($this->errorStatusCode);
        $output->setOutput([
            'message' => $this->errorMessage
                ?? StatusCodeEnum::getOptions()['CODE_' . $this->errorStatusCode],
            'error_code' => $this->errorCode ?? $this->errorStatusCode
        ]);

        if ($this->errorStatusCode === 406) {
            $output->setContentType($this->defaultContentType);
        }
    }
}
