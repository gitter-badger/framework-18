<?php
namespace Viserio\Contracts\Filesystem;

interface Loader
{
    /**
     * Load the given configuration group.
     *
     * @param string      $file
     * @param string|null $group
     * @param string|null $environment
     * @param string|null $namespace
     *
     * @return array
     */
    public function load($file, $group = null, $environment = null, $namespace = null);

    /**
     * Determine if the given file exists.
     *
     * @param string      $file
     * @param string|null $group
     * @param string|null $namespace
     * @param string|null $environment
     *
     * @return bool|array
     */
    public function exists($file, $group = null, $environment = null, $namespace = null);

    /**
     * Apply any cascades to an array of package options.
     *
     * @param string      $file
     * @param string|null $packages
     * @param string|null $group
     * @param string|null $env
     * @param array|null  $items
     * @param string      $namespace
     *
     * @return array
     */
    public function cascadePackage(
        $file,
        $packages = null,
        $group = null,
        $env = null,
        $items = null,
        $namespace = 'packages'
    );
}
