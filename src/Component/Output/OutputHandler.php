<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Component\Output;

use Ulrack\Web\Common\Endpoint\InputInterface;
use Ulrack\Web\Exception\NotAcceptedException;
use Ulrack\Web\Common\Endpoint\OutputInterface;
use Ulrack\Web\Common\Output\HeaderHandlerInterface;
use Ulrack\Web\Common\Output\OutputHandlerInterface;
use Ulrack\Web\Common\Output\OutputConverterInterface;

class OutputHandler implements OutputHandlerInterface
{
    /**
     * Contains the output converters.
     *
     * @var OutputConverterInterface[]
     */
    private $outputConverters;

    /**
     * Contains the header handler.
     *
     * @var HeaderHandlerInterface
     */
    private $headerHandler;

    /**
     * Constructor.
     *
     * @param HeaderHandlerInterface $headerHandler
     * @param OutputConverterInterface ...$outputConverters
     */
    public function __construct(
        HeaderHandlerInterface $headerHandler,
        OutputConverterInterface ...$outputConverters
    ) {
        $this->headerHandler = $headerHandler;
        $this->outputConverters = $outputConverters;
    }

    /**
     * Handles the conversion of the internal output to visible output.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return void
     *
     * @throws NotAcceptedException When there is no converter for the output type.
     */
    public function __invoke(
        InputInterface $input,
        OutputInterface $output
    ): void {
        foreach ($this->outputConverters as $outputConverter) {
            $outputString = $outputConverter($output);
            if ($outputString !== null) {
                $this->headerHandler->__invoke($input, $output);
                echo $outputString;
                return;
            }
        }

        throw new NotAcceptedException('Can not fulfill accepted output.');
    }
}
