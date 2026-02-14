<?php

use KishorRajbanshi\Crypt\Crypter;
use KishorRajbanshi\Crypt\Exceptions\Decrypt;
use KishorRajbanshi\Crypt\Exceptions\Encrypt;

it('encrypts and decrypts string correctly', function () {
    $key = random_bytes(32);
    $crypter = new Crypter($key, 'AES-256-CBC');

    $encrypted = $crypter->encryptString('hello world');
    $decrypted = $crypter->decryptString($encrypted);

    expect($decrypted)->toBe('hello world');
});

it('encrypts and decrypts array correctly', function () {
    $key = random_bytes(32);
    $crypter = new Crypter($key, 'AES-256-CBC');

    $data = ['name' => 'Kishor', 'age' => 25];

    $encrypted = $crypter->encrypt($data);
    $decrypted = $crypter->decrypt($encrypted);

    expect($decrypted)->toBe($data);
});

it('fails with invalid key length', function () {
    new Crypter('short-key', 'AES-256-CBC');
})->throws(RuntimeException::class);

it('fails when payload is tampered', function () {
    $key = random_bytes(32);
    $crypter = new Crypter($key, 'AES-256-CBC');

    $encrypted = $crypter->encryptString('secure');

    // tamper payload
    $tampered = substr($encrypted, 0, -2) . 'xx';

    $crypter->decryptString($tampered);
})->throws(Decrypt::class);

it('fails when decrypting with wrong key', function () {
    $key1 = random_bytes(32);
    $key2 = random_bytes(32);

    $crypter1 = new Crypter($key1, 'AES-256-CBC');
    $crypter2 = new Crypter($key2, 'AES-256-CBC');

    $encrypted = $crypter1->encryptString('secret');

    $crypter2->decryptString($encrypted);
})->throws(Decrypt::class);

it('generates correct key length for AES-128-CBC', function () {
    $key = Crypter::generateKey('AES-128-CBC');

    expect(strlen($key))->toBe(16);
});

it('generates correct key length for AES-256-CBC', function () {
    $key = Crypter::generateKey('AES-256-CBC');

    expect(strlen($key))->toBe(32);
});
