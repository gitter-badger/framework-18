<?php
namespace Viserio\Filesystem\Adapters;

use Viserio\Contracts\Filesystem\Connector as ConnectorContract;

abstract class AbstractConnector implements ConnectorContract
{
    /**
     * {@inheritdoc}
     */
    public function connect(array $config)
    {
        $auth = $this->getAuth($config);
        $client = $this->getClient($auth);
        $config = $this->getConfig($config);

        return $this->getAdapter($client, $config);
    }

    /**
     * Get the authentication data.
     *
     * @param array $config
     *
     * @throws \InvalidArgumentException
     *
     * @return string[]
     */
    abstract protected function getAuth(array $config): array;

    /**
     * Get the awss3 client.
     *
     * @param string[] $auth
     *
     * @return object
     */
    abstract protected function getClient(array $auth);

    /**
     * Get the configuration.
     *
     * @param array $config
     *
     * @throws \InvalidArgumentException
     *
     * @return string[]
     */
    abstract protected function getConfig(array $config): array;

    /**
     * Get the awss3 adapter.
     *
     * @param object   $client
     * @param string[] $config
     *
     * @return object
     */
    abstract protected function getAdapter($client, array $config);
}
