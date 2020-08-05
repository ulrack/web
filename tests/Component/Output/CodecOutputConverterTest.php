<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Tests\Component\Output;

use Exception;
use PHPUnit\Framework\TestCase;
use GrizzIt\Codec\Common\EncoderInterface;
use Ulrack\Web\Common\Endpoint\OutputInterface;
use GrizzIt\Codec\Common\CodecRegistryInterface;
use GrizzIt\Translator\Common\TranslatorInterface;
use Ulrack\Web\Component\Output\CodecOutputConverter;

/**
 * @coversDefaultClass \Ulrack\Web\Component\Output\CodecOutputConverter
 */
class CodecOutputConverterTest extends TestCase
{
    /**
     * @covers ::__invoke
     * @covers ::__construct
     *
     * @return void
     */
    public function testInvoke(): void
    {
        $mimeToCodec = $this->createMock(TranslatorInterface::class);
        $codecRegistry = $this->createMock(CodecRegistryInterface::class);
        $subject = new CodecOutputConverter($mimeToCodec, $codecRegistry);

        $output = $this->createMock(OutputInterface::class);
        $encoder = $this->createMock(EncoderInterface::class);

        $codecRegistry->expects(static::once())
            ->method('getEncoder')
            ->with('json')
            ->willReturn($encoder);

        $mimeToCodec->expects(static::once())
            ->method('getRight')
            ->with('application/json')
            ->willReturn('json');

        $output->expects(static::once())
            ->method('getContentType')
            ->willReturn('application/json');

        $output->expects(static::once())
            ->method('getOutput')
            ->willReturn(['foo' => 'bar']);

        $encoder->expects(static::once())
            ->method('encode')
            ->with(['foo' => 'bar'])
            ->willReturn('{"foo":"bar"}');

        $this->assertEquals('{"foo":"bar"}', $subject->__invoke($output));
    }

    /**
     * @covers ::__invoke
     * @covers ::__construct
     *
     * @return void
     */
    public function testInvokeError(): void
    {
        $mimeToCodec = $this->createMock(TranslatorInterface::class);
        $codecRegistry = $this->createMock(CodecRegistryInterface::class);
        $subject = new CodecOutputConverter($mimeToCodec, $codecRegistry);

        $output = $this->createMock(OutputInterface::class);

        $output->expects(static::once())
            ->method('getContentType')
            ->willThrowException(new Exception());

        $this->assertEquals(null, $subject->__invoke($output));
    }
}
