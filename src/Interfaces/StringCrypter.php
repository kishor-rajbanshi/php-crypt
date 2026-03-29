<?php

namespace KishorRajbanshi\Crypt\Interfaces;

interface StringCrypter
{
    /**
     * Encrypt a string without serialization.
     *
     * @param string $value
     *
     * @throws \KishorRajbanshi\Crypt\Exceptions\Encrypt
     *
     * @return string
     */
    public function encryptString($value);

    /**
     * Decrypt the given string without unserialization.
     *
     * @param string $payload
     *
     * @throws \KishorRajbanshi\Crypt\Exceptions\Decrypt
     *
     * @return string
     */
    public function decryptString($payload);
}
