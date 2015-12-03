<?php
namespace Viserio\Contracts\Database;

/**
 * ConnectionResolver.
 *
 * @author  Daniel Bannert
 *
 * @since   0.9.4
 */
interface ConnectionResolver
{
    /**
     * Get a database connection instance.
     *
     * @param string|null $name
     *
     * @return \Viserio\Database\Connection
     */
    public function connection($name = null);

    /**
     * Get the default connection name.
     *
     * @return string
     */
    public function getDefaultConnection();

    /**
     * Set the default connection name.
     *
     * @param string $name
     */
    public function setDefaultConnection($name);
}
