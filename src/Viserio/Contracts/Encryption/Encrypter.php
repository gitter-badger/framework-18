<?php
namespace Viserio\Contracts\Encryption;

interface Encrypter
{
    /**
     * Encrypts a plaintext string using a secret key.
     *
     * @param string $plaintext
     *
     * @return string
     */
    public function encrypt(string $plaintext): string;

    /**
     * Decrypts a ciphertext string using a secret key.
     *
     * @param string $ciphertext
     *
     * @return string
     */
    public function decrypt(string $ciphertext): string;
}
