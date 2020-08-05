<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Factory;

use Ulrack\Web\Component\Endpoint\Output;
use Ulrack\Web\Common\Endpoint\InputInterface;
use Ulrack\Web\Common\Endpoint\OutputInterface;
use Ulrack\Web\Common\Factory\OutputFactoryInterface;

class OutputFactory implements OutputFactoryInterface
{
    /**
     * Creates the output object based on the input object.
     *
     * @param InputInterface $input
     *
     * @return OutputInterface
     */
    public function create(InputInterface $input): OutputInterface
    {
        $request = $input->getRequest();
        $output = $request->hasHeader('Accept') ? new Output(
            ...$this->parseAcceptHeader(
                $request->getHeader('Accept')
            )
        ) : new Output('*/*');

        $output->setProtocol($request->getProtocol());

        return $output;
    }

    /**
     * Parses and orders the accept headers.
     *
     * @param string $acceptHeader
     *
     * @return string[]
     */
    private function parseAcceptHeader(string $acceptHeader): array
    {
        $accepts = explode(',', $acceptHeader);
        $returnOrder = [];
        foreach ($accepts as $accept) {
            $acceptQuality = explode(';', $accept);
            $quality = 1000;
            if (count($acceptQuality) > 1) {
                if (
                    preg_match(
                        '/q=(\d\.?\d*)/',
                        $acceptQuality[1],
                        $qualityPart
                    ) === 1
                ) {
                    $quality = (int) $qualityPart[1] * 1000;
                }
            }

            $returnOrder[$quality][] = $acceptQuality[0];
        }

        krsort($returnOrder);

        return array_merge(...$returnOrder);
    }
}
