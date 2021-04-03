<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Factory;

use Throwable;
use GrizzIt\Http\Factory\UriFactory;
use Ulrack\Web\Component\Endpoint\Input;
use GrizzIt\Http\Component\Request\Request;
use Ulrack\Web\Common\Endpoint\InputInterface;
use GrizzIt\Codec\Common\CodecRegistryInterface;
use GrizzIt\Http\Component\Cookie\CookieManager;
use GrizzIt\Translator\Common\TranslatorInterface;
use Ulrack\Web\Common\Error\ErrorRegistryInterface;
use GrizzIt\Http\Component\File\UploadedFileManager;
use Ulrack\Web\Exception\UnsupportedMediaTypeException;

class InputFactory
{
    /**
     * Contains the mime to codec translator.
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
     * Contains the URI factory.
     *
     * @var UriFactory
     */
    private UriFactory $uriFactory;

    /**
     * Contains the identifier of the input stream.
     *
     * @var string
     */
    private string $inputStream;

    /**
     * Constructor.
     *
     * @param TranslatorInterface $mimeToCodec
     * @param CodecRegistryInterface $codecRegistry
     * @param ErrorRegistryInterface $errorRegistry
     * @param UriFactory $uriFactory
     */
    public function __construct(
        TranslatorInterface $mimeToCodec,
        CodecRegistryInterface $codecRegistry,
        UriFactory $uriFactory = null,
        string $inputStream = 'php://input'
    ) {
        $this->mimeToCodec = $mimeToCodec;
        $this->codecRegistry = $codecRegistry;
        $this->uriFactory = $uriFactory ?? new UriFactory();
        $this->inputStream = $inputStream;
    }

    /**
     * Creates the input.
     *
     * @param array $server
     * @param array $get
     * @param array $post
     * @param array $files
     * @param array $cookies
     *
     * @return InputInterface
     *
     * @throws UnsupportedMediaTypeException When the request can not be created.
     */
    public function create(
        array $server = [],
        array $get = [],
        array $post = [],
        array $files = [],
        array $cookies = []
    ): InputInterface {
        $fileManager = new UploadedFileManager($files);
        $parsedUri = parse_url($server['REQUEST_URI']);
        $uri = $this->uriFactory->create(
            $server['REQUEST_SCHEME'] ?? '',
            $server['PHP_AUTH_USER'] ?? '',
            $server['PHP_AUTH_PASS'] ?? '',
            $server['HTTP_HOST'] ?? '',
            $server['SERVER_PORT'] ?? -1,
            $parsedUri['path'] ?? '',
            $get,
            $parsedUri['fragment'] ?? ''
        );

        $cookieManager = new CookieManager($cookies);

        $payload = !empty($post) ? $post : null;

        if (
            !empty($server['CONTENT_TYPE']) &&
            $server['CONTENT_TYPE'] !== 'application/x-www-form-urlencoded' &&
            strpos($server['CONTENT_TYPE'], 'multipart/form-data') === false
        ) {
            try {
                $payload = $this->codecRegistry->getDecoder(
                    $this->mimeToCodec->getRight($server['CONTENT_TYPE'])
                )->decode(file_get_contents($this->inputStream));
            } catch (Throwable $exception) {
                throw new UnsupportedMediaTypeException(
                    'Can not decode input.',
                    0,
                    $exception
                );
            }
        }

        return new Input(
            new Request(
                $uri,
                $cookieManager,
                $fileManager,
                $payload,
                $server['SERVER_PROTOCOL'] ?? '',
                $server['REQUEST_METHOD'] ?? '',
                $this->getAllHeaders($server),
                $server
            )
        );
    }

    /**
     * Extracts all HTTP headers from the incoming request.
     *
     * @param array $server
     *
     * @return array
     */
    private function getAllHeaders(array $server): array
    {
        $headers = [];
        foreach ($server as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(
                    ' ',
                    '-',
                    ucwords(
                        strtolower(
                            str_replace(
                                '_',
                                ' ',
                                substr($name, 5)
                            )
                        )
                    )
                )] = $value;
            }
        }

        return $headers;
    }
}
