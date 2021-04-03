<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Component\Output;

use Throwable;
use Ulrack\Web\Common\Endpoint\OutputInterface;
use GrizzIt\Codec\Common\CodecRegistryInterface;
use GrizzIt\Translator\Common\TranslatorInterface;
use Ulrack\Web\Common\Output\OutputConverterInterface;

class CodecOutputConverter implements OutputConverterInterface
{
    /**
     * Contains the translations from mime types to codecs.
     *
     * @var TranslatorInterface
     */
    private TranslatorInterface $mimeToCodec;

    /**
     * Contains the codec registry.
     *
     * @var CodecRegistryInterface
     */
    private CodecRegistryInterface $codecRegistry;

    /**
     * Constructor.
     *
     * @param TranslatorInterface $translator
     * @param CodecRegistryInterface $codecRegistry
     */
    public function __construct(
        TranslatorInterface $mimeToCodec,
        CodecRegistryInterface $codecRegistry
    ) {
        $this->mimeToCodec = $mimeToCodec;
        $this->codecRegistry = $codecRegistry;
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
        try {
            return $this->codecRegistry->getEncoder(
                $this->mimeToCodec->getRight(
                    $output->getContentType()
                )
            )->encode($output->getOutput());
        } catch (Throwable $exception) {
            return null;
        }
    }
}
