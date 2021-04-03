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

class ConfigurablePlainError implements ErrorInterface
{
    /**
     * Contains the error status code.
     *
     * @var int
     */
    private int $errorStatusCode;

    /**
     * Contains the error code.
     *
     * @var int|null
     */
    private ?int $errorCode;

    /**
     * Contains the error message.
     *
     * @var string|null
     */
    private ?string $errorMessage;

    /**
     * Constructor.
     *
     * @param int $errorStatusCode
     * @param int|null $errorCode
     * @param string|null $errorMessage
     */
    public function __construct(
        int $errorStatusCode,
        int $errorCode = null,
        string $errorMessage = null
    ) {
        $this->errorStatusCode = $errorStatusCode;
        $this->errorCode = $errorCode;
        $this->errorMessage = $errorMessage;
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
        $output->setOutput(
            sprintf(
                '%s: %s',
                $this->errorCode ?? $this->errorStatusCode,
                $this->errorMessage
                    ?? StatusCodeEnum::getOptions()[
                        'CODE_' . $this->errorStatusCode
                    ]
            )
        );
        $output->setContentType('text/plain');
    }
}
