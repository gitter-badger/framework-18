<?php

namespace Brainwave\Encryption;

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

use Brainwave\Contracts\Encryption\DecryptException;
use Brainwave\Contracts\Encryption\EncryptException;
use Brainwave\Contracts\Encryption\Encrypter as EncrypterContract;
use Brainwave\Contracts\Encryption\InvalidKeyException;
use Brainwave\Contracts\Hashing\Generator as HashContract;
use Brainwave\Encryption\Adapter\OpenSsl;
use Brainwave\Support\Arr;
use RandomLib\Generator as RandomLib;

/**
 * Encrypter.
 *
 * @author  Daniel Bannert
 *
 * @since   0.8.0-dev
 */
class Encrypter implements EncrypterContract
{
    /**
     * Encryption key
     * should be correct length for selected cipher.
     *
     * @var string
     */
    protected $key;

    /**
     * Supported data structure.
     *
     * @var array
     */
    protected $dataStructure = [
        'algo' => true,
        'mode' => true,
        'iv' => true,
        'cdata' => true,
        'mac' => true,
    ];

    /**
     * Hash generator instance.
     *
     * @var \Brainwave\Contracts\Hashing\Generator
     */
    protected $hash;

    /**
     * RandomLib instance.
     *
     * @var \RandomLib\Generator
     */
    protected $rand;

    /**
     * The algorithm used for encryption.
     *
     * @var string
     */
    protected $cipher;

    /**
     * The mode used for encryption.
     *
     * @var string
     */
    protected $mode;

    /**
     * Extension.
     *
     * @var \Brainwave\Contracts\Encryption\Adapter
     */
    protected $generator;

    /**
     * Constructor.
     *
     * @param \Brainwave\Contracts\Hashing\Generator $hash
     * @param \RandomLib\Generator                   $rand
     * @param string                                 $key    Encryption key
     * @param string                                 $cipher Encryption $cipher
     * @param string                                 $mode   Encryption $mode
     */
    public function __construct(HashContract $hash, RandomLib $rand, $key, $cipher = 'AES-256', $mode = 'CBC')
    {
        $this->secruityCheck($key, $cipher, $mode);

        $this->hash = $hash;
        $this->rand = $rand;

        $this->generator = new OpenSsl($this->hash, $this->rand, $this->key, $this->cipher, $this->mode);

        $this->generator->setup();
    }

    /**
     * Set the encryption key.
     *
     * @param string $key
     *
     * @return $this
     */
    public function setKey($key)
    {
        $this->key = (string) $key;

        return $this;
    }

    /**
     * Encrypt data returning a JSON encoded array safe for storage in a database
     * or file. The array has the following structure before it is encoded:.
     *
     * [
     *   'cdata' => 'Encrypted data, Base 64 encoded',
     *   'iv'    => 'Base64 encoded IV',
     *   'algo'  => 'Algorythm used',
     *   'mode'  => 'Mode used',
     *   'mac'   => 'Message Authentication Code'
     * ]
     *
     * @param mixed $data Data to encrypt.
     *
     * @return string Serialized array containing the encrypted data
     *                along with some meta data.
     */
    public function encrypt($data)
    {
        $this->checkKey();

        $value = $this->generator->encrypt($data);

        if ($value === false) {
            throw new EncryptException('Could not encrypt the data.');
        }

        return json_encode($value);
    }

    /**
     * Strip PKCS7 padding and decrypt
     * data encrypted by encrypt().
     *
     * @param string $data JSON string containing the encrypted data and meta information in the
     *                     excact format as returned by encrypt().
     *
     * @return string Decrypted data in it's original form.
     */
    public function decrypt($data)
    {
        $this->checkKey();

        // Decode the JSON string
        $data = json_decode($data, true);

        if ($data === null || Arr::check($data, $this->dataStructure, false) !== true) {
            throw new DecryptException('Invalid data passed to decrypt()');
        }

        $decrypted = $this->generator->decrypt($data);

        if ($decrypted === false) {
            throw new DecryptException('Could not decrypt the data.');
        }

        // Return decrypted data.
        return unserialize($decrypted);
    }

    /**
     * Get generator.
     *
     * @return \Brainwave\Contracts\Encryption\Adapter
     */
    public function getGenerator()
    {
        return $this->generator;
    }

    /**
     * Check the current key is usable to perform cryptographic operations.
     *
     * @throws \Brainwave\Encryption\InvalidKeyException
     */
    protected function checkKey()
    {
        if ($this->key === '' || $this->key === 'SomeRandomString') {
            throw new InvalidKeyException('The encryption key must be not be empty.');
        }

        if (strlen($this->key) < '32') {
            throw new InvalidKeyException('The encryption key must be a random string.');
        }
    }

    /**
     * Check key if it has the right length and the right cipher + mode is set
     *
     * @param  string $key
     * @param  string $cipher
     * @param  string $mode
     *
     * @throws \RuntimeException
     */
    protected function secruityCheck($key, $cipher, $mode)
    {
        $len = mb_strlen($key = (string) $key, '8bit');

        if (($len === 16 && $cipher === 'AES-128') || ($len === 32 && $cipher === 'AES-256')) {
            $this->key = $key;
        } else {
            throw new \RuntimeException('The only supported key lengths are 16 bytes and 32 bytes.');
        }

        if (($cipher === 'AES-128' || $cipher === 'AES-256') && $mode === 'CBC') {
            $this->cipher = $cipher;
            $this->mode   = $mode;
        } else {
            throw new \RuntimeException('The only supported ciphers are AES-128-CBC and AES-256-CBC.');
        }
    }
}
