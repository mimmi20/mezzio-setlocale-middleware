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

namespace Mimmi20\Mezzio\Middleware;

use Laminas\I18n\Translator\Translator;
use Locale;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

use function array_key_exists;
use function is_string;

final class SetLocaleMiddleware implements MiddlewareInterface
{
    private string | null $defaultLocale = null;
    private string $fallbackLocale       = 'de_DE';

    /** @throws void */
    public function __construct(private readonly Translator $translator, string | null $defaultLocale = null)
    {
        if ($defaultLocale) {
            $this->defaultLocale = $defaultLocale;
        }
    }

    /** @throws void */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $serverParams = $request->getServerParams();
        $locale       = null;

        if (
            array_key_exists('HTTP_ACCEPT_LANGUAGE', $serverParams)
            && is_string($serverParams['HTTP_ACCEPT_LANGUAGE'])
        ) {
            $locale = Locale::acceptFromHttp($serverParams['HTTP_ACCEPT_LANGUAGE']);
        }

        if (!is_string($locale)) {
            $locale = $this->defaultLocale ?: $this->fallbackLocale;
        }

        $locale   = Locale::canonicalize($locale);
        $language = Locale::getPrimaryLanguage($locale);

        $request = $request->withAttribute('language', $language);
        $request = $request->withAttribute('locale', $locale);

        Locale::setDefault($locale);
        $this->translator->setLocale($language);

        return $handler->handle($request);
    }
}
