<?php
namespace Viserio\Parsers\Proxies;

use Viserio\StaticalProxy\StaticalProxy;

class Parser extends StaticalProxy
{
    protected static function getFacadeAccessor()
    {
        return 'parser';
    }
}
