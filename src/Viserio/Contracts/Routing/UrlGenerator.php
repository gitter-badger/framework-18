<?php
namespace Viserio\Contracts\Routing;

/**
 * UrlGenerator.
 *
 * @author  Daniel Bannert
 *
 * @since   0.9.5
 */
interface UrlGenerator
{
    /**
     * Generate a URL for the given route.
     *
     * @param string $name       The name of the route to generate a url for
     * @param array  $parameters Parameters to pass to the route
     * @param bool   $absolute   If true, the generated route should be absolute
     *
     * @return string
     */
    public function generate($name, array $parameters = [], $absolute = false);
}
