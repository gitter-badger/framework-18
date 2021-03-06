<?php
namespace Viserio\Session\Proxies;

use Viserio\StaticalProxy\StaticalProxy;

class Sessions extends StaticalProxy
{
    protected static function getFacadeAccessor()
    {
        return 'session';
    }
}
