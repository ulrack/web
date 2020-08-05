<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Component\Output;

use Ulrack\Web\Common\Endpoint\OutputInterface;
use Ulrack\Web\Common\Output\OutputConverterInterface;

class PlainOutputConverter implements OutputConverterInterface
{
    /**
     * Contains the allowed content types for the plain converter.
     *
     * @var string[]
     */
    private $contentTypes;

    /**
     * Constructor.
     *
     * @param string[] $contentTypes
     */
    public function __construct(
        array $contentTypes = ['text/plain']
    ) {
        $this->contentTypes = $contentTypes;
    }

    /**
     * Converts the registered output to a string.
     *
     * @param OutputInterface $output
     *
     * @return string|null
     */
    public function __invoke(OutputInterface $output): ?string
    {
        $outputContent = $output->getOutput();

        if (in_array($output->getContentType(), $this->contentTypes)) {
            if (is_string($outputContent)) {
                return $outputContent;
            } elseif (
                is_array($outputContent) &&
                isset($outputContent['message'], $outputContent['error_code'])
            ) {
                return sprintf(
                    '%s: %s',
                    $outputContent['error_code'],
                    $outputContent['message']
                );
            }
        }

        return null;
    }
}
