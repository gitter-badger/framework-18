<?php
namespace Viserio\Cookie\Proxies;

use Viserio\Support\StaticalProxyManager;

/**
 * Cookie.
 *
 * @author  Daniel Bannert
 *
 * @since   0.9.1
 */
class Cookie extends StaticalProxyManager
{
    protected static function getFacadeAccessor()
    {
        return 'cookie';
    }
}
