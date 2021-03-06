<?php
namespace Viserio\Filesystem\Adapters;

use InvalidArgumentException;
use League\Flysystem\GridFS\GridFSAdapter;
use Mongo;
use MongoClient;
use Narrowspark\Arr\StaticArr as Arr;

class GridFSConnector extends AbstractConnector
{
    /**
     * {@inheritdoc}
     */
    protected function getAuth(array $config): array
    {
        if (! array_key_exists('server', $config)) {
            throw new InvalidArgumentException('The gridfs connector requires server configuration.');
        }

        return Arr::only($config, ['server']);
    }

    /**
     * {@inheritdoc}
     */
    protected function getClient(array $auth)
    {
        $mongo = $this->getMongoClass();

        return new $mongo($auth['server']);
    }

    /**
     * {@inheritdoc}
     */
    protected function getConfig(array $config): array
    {
        if (! array_key_exists('database', $config)) {
            throw new InvalidArgumentException('The gridfs connector requires database configuration.');
        }

        return Arr::only($config, ['database']);
    }

    /**
     * {@inheritdoc}
     */
    protected function getAdapter($client, array $config): \League\Flysystem\AdapterInterface
    {
        return new GridFSAdapter($client->selectDB($config['database'])->getGridFS());
    }

    /**
     * Returns the valid Mongo class client for the current php driver.
     *
     * @return string
     */
    protected function getMongoClass(): string
    {
        if (class_exists(MongoClient::class)) {
            return MongoClient::class;
        }

        return Mongo::class;
    }
}
