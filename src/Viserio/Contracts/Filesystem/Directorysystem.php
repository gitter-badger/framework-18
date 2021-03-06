<?php
namespace Viserio\Contracts\Filesystem;

interface Directorysystem
{
    /**
     * Get all of the directories within a given directory.
     *
     * @param string $directory
     *
     * @return array
     */
    public function directories(string $directory): array;

    /**
     * Get all (recursive) of the directories within a given directory.
     *
     * @param string $directory
     *
     * @return array
     */
    public function allDirectories(string $directory): array;

    /**
     * Recursively create a directory.
     *
     * @param string $dirname
     * @param array  $config
     *
     * @return bool
     */
    public function createDirectory(string $dirname, array $config = []): bool;

    /**
     * Recursively delete a directory.
     *
     * @param string $dirname
     *
     * @return bool
     */
    public function deleteDirectory(string $dirname): bool;

    /**
     * Empty the specified directory of all files and folders.
     *
     * @param string $dirname
     *
     * @return bool
     */
    public function cleanDirectory(string $dirname): bool;

    /**
     * Determine if the given path is a directory.
     *
     * @param string $dirname
     *
     * @return bool
     */
    public function isDirectory(string $dirname): bool;
}
