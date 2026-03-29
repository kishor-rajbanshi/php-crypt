<?php

namespace KishorRajbanshi\Crypt\Interfaces;

interface Crypter
{
    /**
     * Encrypt the given value.
     *
     * @param mixed $value
     * @param bool  $serialize
     *
     * @throws \KishorRajbanshi\Crypt\Exceptions\Encrypt
     *
     * @return string
     */
    public function encrypt($value, $serialize = true);

    /**
     * Decrypt the given value.
     *
     * @param string $payload
     * @param bool   $unserialize
     *
     * @throws \KishorRajbanshi\Crypt\Exceptions\Decrypt
     *
     * @return mixed
     */
    public function decrypt($payload, $unserialize = true);
}
