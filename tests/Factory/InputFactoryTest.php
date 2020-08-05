<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Tests\Factory;

use Exception;
use PHPUnit\Framework\TestCase;
use GrizzIt\Http\Factory\UriFactory;
use Ulrack\Web\Factory\InputFactory;
use GrizzIt\Codec\Common\DecoderInterface;
use Ulrack\Web\Common\Endpoint\InputInterface;
use GrizzIt\Codec\Common\CodecRegistryInterface;
use GrizzIt\Translator\Common\TranslatorInterface;
use Ulrack\Web\Exception\UnsupportedMediaTypeException;

/**
 * @coversDefaultClass \Ulrack\Web\Factory\InputFactory
 * @covers \Ulrack\Web\Exception\UnsupportedMediaTypeException
 * @covers \Ulrack\Web\Exception\HttpException
 */
class InputFactoryTest extends TestCase
{
    /**
     * @covers ::create
     * @covers ::getAllHeaders
     * @covers ::__construct
     *
     * @return void
     */
    public function testCreate(): void
    {
        $mimeToCodec = $this->createMock(TranslatorInterface::class);
        $codec = $this->createMock(DecoderInterface::class);
        $codecRegistry = $this->createMock(CodecRegistryInterface::class);
        $uriFactory = $this->createMock(UriFactory::class);

        $mimeToCodec->expects(static::once())
            ->method('getRight')
            ->with('application/json')
            ->willReturn('json-codec');

        $codecRegistry->expects(static::once())
            ->method('getDecoder')
            ->with('json-codec')
            ->willReturn($codec);

        $codec->expects(static::once())
            ->method('decode')
            ->with('{"foo": "bar"}')
            ->willReturn(['foo' => 'bar']);

        $streamInput = tempnam(sys_get_temp_dir(), 'testRead');
        $writeStream = fopen($streamInput, 'w');
        fwrite($writeStream, '{"foo": "bar"}');

        $subject = new InputFactory(
            $mimeToCodec,
            $codecRegistry,
            $uriFactory,
            $streamInput
        );

        $server = [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_HOST' => 'foo.bar',
            'HTTP_CONNECTION' => 'keep-alive',
            'HTTP_CACHE_CONTROL' => 'max-age=0',
            'HTTP_UPGRADE_INSECURE_REQUESTS' => '1',
            'HTTP_ACCEPT' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
            'HTTP_ACCEPT_ENCODING' => 'gzip, deflate',
            'HTTP_ACCEPT_LANGUAGE' => 'en-US,en;q=0.9',
            'SERVER_NAME' => 'foo.bar',
            'SERVER_ADDR' => '127.0.0.1',
            'SERVER_PORT' => '80',
            'REMOTE_ADDR' => '127.0.0.1',
            'REQUEST_SCHEME' => 'http',
            'SERVER_PROTOCOL' => 'HTTP/2.0',
            'REQUEST_METHOD' => 'GET',
            'QUERY_STRING' => 'foo=bar&baz=qux',
            'REQUEST_URI' => '/pub/index.php',
            'SCRIPT_NAME' => '/pub/index.php',
            'PHP_SELF' => '/pub/index.php'
        ];

        $this->assertInstanceOf(
            InputInterface::class,
            $subject->create($server, [], [], [], [])
        );
    }

    /**
     * @covers ::create
     * @covers ::__construct
     *
     * @return void
     */
    public function testCreateFailure(): void
    {
        $mimeToCodec = $this->createMock(TranslatorInterface::class);
        $codecRegistry = $this->createMock(CodecRegistryInterface::class);
        $uriFactory = $this->createMock(UriFactory::class);

        $mimeToCodec->expects(static::once())
            ->method('getRight')
            ->with('application/json')
            ->willReturn('json-codec');

        $codecRegistry->expects(static::once())
            ->method('getDecoder')
            ->with('json-codec')
            ->willThrowException(new Exception());

        $subject = new InputFactory(
            $mimeToCodec,
            $codecRegistry,
            $uriFactory
        );

        $server = [
            'CONTENT_TYPE' => 'application/json',
            'REQUEST_URI' => '/pub/index.php'
        ];

        $this->expectException(UnsupportedMediaTypeException::class);

        $subject->create($server, [], [], [], []);
    }
}
