<?php
namespace Viserio\Contracts\Container;

/**
 * Narrowspark - a PHP 5 framework.
 *
 * @author      Daniel Bannert <info@anolilab.de>
 * @copyright   2015 Daniel Bannert
 *
 * @link        http://www.narrowspark.de
 *
 * @license     http://www.narrowspark.com/license
 *
 * @version     0.10.0-dev
 */

/**
 * Container.
 *
 * @author  Daniel Bannert
 *
 * @since   0.9.4-dev
 */
interface Container
{
    /**
     * Alias a type to a different name.
     *
     * @param string $abstract
     * @param string $alias
     */
    public function alias($abstract, $alias);

    /**
     * Extend an existing binding.
     *
     * @param string   $binding The name of the binding to extend.
     * @param \Closure $closure The function to use to extend the existing binding.
     *
     * @throws ContainerException
     */
    public function extend($binding, \Closure $closure);

    /**
     * Removes an entry from the container.
     *
     * @param string $id Identifier of the entry to remove
     */
    public function remove($id);

    /**
     * Define a contextual binding.
     *
     * @param string $concrete
     *
     * @return \Viserio\Contracts\Container\ContextualBindingBuilder
     */
    public function when($concrete);

    /**
     * Determine if the given abstract type has been bound.
     *
     * @param string $abstract
     *
     * @return bool
     */
    public function bound($abstract);

    /**
     * Check if an item is being managed as a singleton.
     *
     * @param string $alias
     *
     * @return bool
     */
    public function isSingleton($alias);

    /**
     * Call the given Closure and inject its dependencies.
     *
     * @param callable $callable
     * @param array    $args
     *
     * @throws \RuntimeException
     *
     * @return mixed
     */
    public function call($callable, array $args = []);

    /**
     * Register a service provider with the application.
     *
     * @param string $provider
     * @param array  $options
     * @param bool   $force
     *
     * @return \Viserio\Contract\Application\ServiceProvider
     */
    public function provider($provider, $options = [], $force = false);
}
