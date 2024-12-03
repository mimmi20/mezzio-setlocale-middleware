<?php

/**
 * This file is part of the mimmi20/mezzio-setlocale-middleware package.
 *
 * Copyright (c) 2024, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Mimmi20Test\Mezzio\Middleware;

use AssertionError;
use Laminas\I18n\Translator\Translator;
use Laminas\Translator\TranslatorInterface;
use Mimmi20\Mezzio\Middleware\SetLocaleMiddleware;
use Mimmi20\Mezzio\Middleware\SetLocaleMiddlewareFactory;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use ReflectionException;
use ReflectionProperty;

use function assert;

final class SetLocaleMiddlewareFactoryTest extends TestCase
{
    /**
     * @throws Exception
     * @throws ContainerExceptionInterface
     * @throws ReflectionException
     */
    public function testInvoke(): void
    {
        $translator = $this->createMock(Translator::class);

        $container = $this->getMockBuilder(ContainerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $container->expects(self::never())
            ->method('has');
        $container->expects(self::once())
            ->method('get')
            ->with(TranslatorInterface::class)
            ->willReturn($translator);

        $factory = new SetLocaleMiddlewareFactory();

        assert($container instanceof ContainerInterface);
        $result = $factory($container);

        self::assertInstanceOf(SetLocaleMiddleware::class, $result);

        $dL = new ReflectionProperty($result, 'defaultLocale');

        self::assertSame('de_DE', $dL->getValue($result));
    }

    /**
     * @throws Exception
     * @throws ContainerExceptionInterface
     */
    public function testInvokeFailed(): void
    {
        $translator = $this->createMock(TranslatorInterface::class);

        $container = $this->getMockBuilder(ContainerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $container->expects(self::never())
            ->method('has');
        $container->expects(self::once())
            ->method('get')
            ->with(TranslatorInterface::class)
            ->willReturn($translator);

        $factory = new SetLocaleMiddlewareFactory();

        assert($container instanceof ContainerInterface);

        $this->expectException(AssertionError::class);
        $this->expectExceptionMessage('assert($translator instanceof Translator)');
        $this->expectExceptionCode(1);

        $factory($container);
    }
}
