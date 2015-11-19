<?php
namespace Viserio\Container\Traits;

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

use Interop\Container\ContainerInterface;

/**
 * DelegateTrait.
 *
 * @author  Daniel Bannert
 *
 * @since   0.10.0-dev
 */
trait DelegateTrait
{
    /**
     * @var \Interop\Container\ContainerInterface[]
     */
    protected $delegates = [];

    /**
     * Delegate a backup container to be checked for services if it
     * cannot be resolved via this container.
     *
     * @param \Interop\Container\ContainerInterface $container
     *
     * @return $this
     */
    public function delegate(ContainerInterface $container)
    {
        $this->delegates[] = $container;

        return $this;
    }

    /**
     * Returns true if service is registered in one of the delegated backup containers.
     *
     * @param string $alias
     *
     * @return boolean
     */
    public function hasInDelegate($alias)
    {
        foreach ($this->delegates as $container) {
            if ($container->has($alias)) {
                return true;
            }
        }
        return false;
    }
    /**
     * Attempt to get a service from the stack of delegated backup containers.
     *
     * @param string $alias
     * @param array  $args
     *
     * @return mixed
     */
    protected function getFromDelegate($alias)
    {
        foreach ($this->delegates as $container) {
            if ($container->has($alias)) {
                return $container->get($alias);
            }

            continue;
        }

        return false;
    }
}