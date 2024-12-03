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

use Laminas\I18n\Translator\Translator;
use Locale;
use Mimmi20\Mezzio\Middleware\SetLocaleMiddleware;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class SetLocaleMiddlewareTest extends TestCase
{
    /**
     * @throws Exception
     * @throws ContainerExceptionInterface
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testInvoke(): void
    {
        $language = 'en';

        $translator = $this->createMock(Translator::class);
        $translator->expects(self::once())
            ->method('setLocale')
            ->with($language);

        $request = $this->createMock(ServerRequestInterface::class);
        $request->expects(self::once())
            ->method('getServerParams')
            ->willReturn(['HTTP_ACCEPT_LANGUAGE' => 'en-US;q=0.8,en;q=0.7']);
        $matcher = self::exactly(2);
        $request->expects($matcher)
            ->method('withAttribute')
            ->willReturnCallback(
                static function (string $name, mixed $value) use ($matcher, $request, $language): ServerRequestInterface {
                    $invocation = $matcher->numberOfInvocations();

                    match ($invocation) {
                        1 => self::assertSame('language', $name, (string) $invocation),
                        default => self::assertSame('locale', $name, (string) $invocation),
                    };

                    match ($invocation) {
                        1 => self::assertSame($language, $value, (string) $invocation),
                        default => self::assertSame('en_US', $value, (string) $invocation),
                    };

                    return $request;
                },
            );

        $res = $this->createMock(ResponseInterface::class);

        $handler = $this->createMock(RequestHandlerInterface::class);
        $handler->expects(self::once())
            ->method('handle')
            ->with($request)
            ->willReturn($res);

        $middleware = new SetLocaleMiddleware($translator, 'fr_FR');
        $response   = $middleware->process($request, $handler);

        self::assertSame($res, $response);
        self::assertSame('en_US', Locale::getDefault());
    }

    /**
     * @throws Exception
     * @throws ContainerExceptionInterface
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testInvoke2(): void
    {
        $language = 'fr';

        $translator = $this->createMock(Translator::class);
        $translator->expects(self::once())
            ->method('setLocale')
            ->with($language);

        $request = $this->createMock(ServerRequestInterface::class);
        $request->expects(self::once())
            ->method('getServerParams')
            ->willReturn(['HTTP_ACCEPT_LANGUAGE' => null]);
        $matcher = self::exactly(2);
        $request->expects($matcher)
            ->method('withAttribute')
            ->willReturnCallback(
                static function (string $name, mixed $value) use ($matcher, $request, $language): ServerRequestInterface {
                    $invocation = $matcher->numberOfInvocations();

                    match ($invocation) {
                        1 => self::assertSame('language', $name, (string) $invocation),
                        default => self::assertSame('locale', $name, (string) $invocation),
                    };

                    match ($invocation) {
                        1 => self::assertSame($language, $value, (string) $invocation),
                        default => self::assertSame('fr_FR', $value, (string) $invocation),
                    };

                    return $request;
                },
            );

        $res = $this->createMock(ResponseInterface::class);

        $handler = $this->createMock(RequestHandlerInterface::class);
        $handler->expects(self::once())
            ->method('handle')
            ->with($request)
            ->willReturn($res);

        $middleware = new SetLocaleMiddleware($translator, 'fr_FR');
        $response   = $middleware->process($request, $handler);

        self::assertSame($res, $response);
        self::assertSame('fr_FR', Locale::getDefault());
    }

    /**
     * @throws Exception
     * @throws ContainerExceptionInterface
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testInvoke3(): void
    {
        $language = 'fr';

        $translator = $this->createMock(Translator::class);
        $translator->expects(self::once())
            ->method('setLocale')
            ->with($language);

        $request = $this->createMock(ServerRequestInterface::class);
        $request->expects(self::once())
            ->method('getServerParams')
            ->willReturn([]);
        $matcher = self::exactly(2);
        $request->expects($matcher)
            ->method('withAttribute')
            ->willReturnCallback(
                static function (string $name, mixed $value) use ($matcher, $request, $language): ServerRequestInterface {
                    $invocation = $matcher->numberOfInvocations();

                    match ($invocation) {
                        1 => self::assertSame('language', $name, (string) $invocation),
                        default => self::assertSame('locale', $name, (string) $invocation),
                    };

                    match ($invocation) {
                        1 => self::assertSame($language, $value, (string) $invocation),
                        default => self::assertSame('fr_FR', $value, (string) $invocation),
                    };

                    return $request;
                },
            );

        $res = $this->createMock(ResponseInterface::class);

        $handler = $this->createMock(RequestHandlerInterface::class);
        $handler->expects(self::once())
            ->method('handle')
            ->with($request)
            ->willReturn($res);

        $middleware = new SetLocaleMiddleware($translator, 'fr_FR');
        $response   = $middleware->process($request, $handler);

        self::assertSame($res, $response);
        self::assertSame('fr_FR', Locale::getDefault());
    }

    /**
     * @throws Exception
     * @throws ContainerExceptionInterface
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testInvoke4(): void
    {
        $language = 'de';

        $translator = $this->createMock(Translator::class);
        $translator->expects(self::once())
            ->method('setLocale')
            ->with($language);

        $request = $this->createMock(ServerRequestInterface::class);
        $request->expects(self::once())
            ->method('getServerParams')
            ->willReturn([]);
        $matcher = self::exactly(2);
        $request->expects($matcher)
            ->method('withAttribute')
            ->willReturnCallback(
                static function (string $name, mixed $value) use ($matcher, $request, $language): ServerRequestInterface {
                    $invocation = $matcher->numberOfInvocations();

                    match ($invocation) {
                        1 => self::assertSame('language', $name, (string) $invocation),
                        default => self::assertSame('locale', $name, (string) $invocation),
                    };

                    match ($invocation) {
                        1 => self::assertSame($language, $value, (string) $invocation),
                        default => self::assertSame('de_DE', $value, (string) $invocation),
                    };

                    return $request;
                },
            );

        $res = $this->createMock(ResponseInterface::class);

        $handler = $this->createMock(RequestHandlerInterface::class);
        $handler->expects(self::once())
            ->method('handle')
            ->with($request)
            ->willReturn($res);

        $middleware = new SetLocaleMiddleware($translator);
        $response   = $middleware->process($request, $handler);

        self::assertSame($res, $response);
        self::assertSame('de_DE', Locale::getDefault());
    }

    /**
     * @throws Exception
     * @throws ContainerExceptionInterface
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testInvoke5(): void
    {
        $language = 'de';

        $translator = $this->createMock(Translator::class);
        $translator->expects(self::once())
            ->method('setLocale')
            ->with($language);

        $request = $this->createMock(ServerRequestInterface::class);
        $request->expects(self::once())
            ->method('getServerParams')
            ->willReturn([]);
        $matcher = self::exactly(2);
        $request->expects($matcher)
            ->method('withAttribute')
            ->willReturnCallback(
                static function (string $name, mixed $value) use ($matcher, $request, $language): ServerRequestInterface {
                    $invocation = $matcher->numberOfInvocations();

                    match ($invocation) {
                        1 => self::assertSame('language', $name, (string) $invocation),
                        default => self::assertSame('locale', $name, (string) $invocation),
                    };

                    match ($invocation) {
                        1 => self::assertSame($language, $value, (string) $invocation),
                        default => self::assertSame('de_DE', $value, (string) $invocation),
                    };

                    return $request;
                },
            );

        $res = $this->createMock(ResponseInterface::class);

        $handler = $this->createMock(RequestHandlerInterface::class);
        $handler->expects(self::once())
            ->method('handle')
            ->with($request)
            ->willReturn($res);

        $middleware = new SetLocaleMiddleware(
            $translator,
            'char(119)+char(104)+char(115)+char(100)+char(98)+char(116)+char(101)+char(115)+char(116)+char(119)+char(104)+char(115)+char(100)+char(98)+char(116)+char(101)+char(115)+char(116)',
        );
        $response   = $middleware->process($request, $handler);

        self::assertSame($res, $response);
        self::assertSame('de_DE', Locale::getDefault());
    }
}
