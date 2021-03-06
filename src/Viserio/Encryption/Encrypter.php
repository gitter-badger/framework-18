<?php
namespace Viserio\Encryption;

use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;
use Viserio\Contracts\Encryption\Encrypter as EncrypterContract;

class Encrypter implements EncrypterContract
{
    /**
     * Encryption key.
     *
     * @var \Defuse\Crypto\Key
     */
    protected $key;

    /**
     * Create a new Encrypter instance.
     *
     * @param \Defuse\Crypto\Key $key
     */
    public function __construct(Key $key)
    {
        $this->key = $key;
    }

    /**
     * {@inheritdoc}
     */
    public function encrypt(string $plaintext): string
    {
        return Crypto::encrypt($plaintext, $this->key);
    }

    /**
     * {@inheritdoc}
     */
    public function decrypt(string $ciphertext): string
    {
        return Crypto::decrypt($ciphertext, $this->key);
    }

    /**
     * Compare two encrypted values.
     *
     * @param bool   $loose
     * @param string $encrypted1
     * @param string $encrypted2
     *
     * @return bool
     */
    public function compare(string $encrypted1, string $encrypted2, bool $loose = false): bool
    {
        $encrypt1 = $this->decrypt($encrypted1);
        $encrypt2 = $this->decrypt($encrypted2);

        if ($loose) {
            return $encrypt1 == $encrypt2;
        }

        return $encrypt1 === $encrypt2;
    }
}
