<?php
namespace Viserio\Contracts\Hashing;

/**
 * Password.
 *
 * @author  Daniel Bannert
 *
 * @since   0.9.4
 */
interface Password
{
    /**
     * Hash the given value.
     *
     * @param string $value
     * @param array  $options
     *
     * @throws \RuntimeException
     *
     * @return string
     */
    public function make($value, array $options = []);

    /**
     * Check the given plain value against a hash.
     *
     * @param string $value
     * @param string $hashedValue
     * @param array  $options
     *
     * @return bool
     */
    public function check($value, $hashedValue, array $options = []);

    /**
     * Check if the given hash has been hashed using the given options.
     *
     * @param string $hashedValue
     * @param array  $options
     *
     * @return bool
     */
    public function needsRehash($hashedValue, array $options = []);
}
