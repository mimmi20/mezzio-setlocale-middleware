<?php

/**
 * This file is part of the mimmi20/mezzio-setlocale-middleware package.
 *
 * Copyright (c) 2024-2025, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Mimmi20\Mezzio\Middleware;

use Laminas\I18n\Translator\Translator;
use Laminas\Translator\TranslatorInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;

use function assert;

final class SetLocaleMiddlewareFactory
{
    /** @throws ContainerExceptionInterface */
    public function __invoke(ContainerInterface $container): SetLocaleMiddleware
    {
        $translator = $container->get(TranslatorInterface::class);

        assert($translator instanceof Translator);

        return new SetLocaleMiddleware($translator, 'de_DE');
    }
}
