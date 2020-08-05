<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Component\Output;

use Ulrack\Web\Common\Output\StatusCodeEnum;
use Ulrack\Web\Common\Endpoint\InputInterface;
use Ulrack\Web\Common\Endpoint\OutputInterface;
use Ulrack\Web\Common\Output\HeaderHandlerInterface;

class HeaderHandler implements HeaderHandlerInterface
{
    /**
     * Sends out the headers.
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
        $statusCode = $output->getStatusCode();

        header(sprintf(
            '%s %d %s',
            $input->getRequest()->getServerVariable('SERVER_PROTOCOL'),
            $statusCode,
            StatusCodeEnum::getOptions()['CODE_' . $statusCode]
        ));

        foreach ($output->getHeaderKeys() as $headerKey) {
            if (
                $output->hasHeader($headerKey) &&
                $headerKey !== 'Content-Type'
            ) {
                header(
                    sprintf(
                        '%s: %s',
                        $headerKey,
                        $output->getHeader($headerKey)
                    )
                );
            }
        }

        header('Content-Type: ' . $output->getContentType());
    }
}
