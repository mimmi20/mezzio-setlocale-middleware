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
use Laminas\I18n\Translator\TranslatorInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\MiddlewareInterface;

use function assert;

final class SetLocaleMiddlewareFactory
{
    /** @throws ContainerExceptionInterface */
    public function __invoke(ContainerInterface $container): MiddlewareInterface
    {
        $translator = $container->get(TranslatorInterface::class);

        assert($translator instanceof Translator);

        return new SetLocaleMiddleware($translator, 'de_DE');
    }
}
