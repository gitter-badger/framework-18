<?php
namespace Viserio\Events\Proxies;

use Viserio\StaticalProxy\StaticalProxy;

class Events extends StaticalProxy
{
    protected static function getFacadeAccessor()
    {
        return 'events';
    }
}
