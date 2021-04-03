<?php

declare(strict_types=1);

namespace Atk4\I18n\Resource;

use Atk4\I18n\Service;

if (!\function_exists(_t::class)) {
    function _t(string $id, array $param = [], string $domain = null, string $locale = null): string
    {
        return Service::getTranslator()->trans($id, $param, $domain, $locale);
    }
}
