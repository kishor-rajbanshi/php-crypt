# PHP Crypt

A lightweight encryption and decryption library built on top of OpenSSL, supporting:

- AES-128-CBC
- AES-256-CBC
- MAC validation (HMAC SHA-256)
- Secure payload structure (IV + value + MAC)
- String and serialized value encryption

## Installation

```bash
composer require kishor-rajbanshi/php-crypt
````

## Supported Ciphers

* `AES-128-CBC` (requires 16-byte key)
* `AES-256-CBC` (requires 32-byte key)

## Generating a Key

```php
use KishorRajbanshi\Crypt\Crypter;

$key = Crypter::generateKey('AES-256-CBC');
```

## Basic Usage

### Create Crypter Instance

```php
use KishorRajbanshi\Crypt\Crypter;

$key = random_bytes(32); // 32 bytes for AES-256-CBC
$crypter = new Crypter($key, 'AES-256-CBC');
```

### Encrypt & Decrypt Any Value (Serialized)

```php
$data = ['name' => 'Kishor', 'role' => 'Developer'];

$encrypted = $crypter->encrypt($data);

$decrypted = $crypter->decrypt($encrypted);

print_r($decrypted);
```

### Encrypt & Decrypt Strings Only (No Serialization)

```php
$encrypted = $crypter->encryptString('Hello World');

$decrypted = $crypter->decryptString($encrypted);
```

## Payload Structure

Encrypted payload is:

```
base64_encode(json_encode([
    'iv' => base64_encoded_iv,
    'value' => encrypted_value,
    'mac' => hmac_sha256
]))
```

The MAC ensures data integrity and prevents tampering.

## Exception Handling

The package throws custom exceptions:

* `KishorRajbanshi\Crypt\Exceptions\Encrypt`
* `KishorRajbanshi\Crypt\Exceptions\Decrypt`

### Example

```php
use KishorRajbanshi\Crypt\Exceptions\Decrypt;
use KishorRajbanshi\Crypt\Exceptions\Encrypt;

try {
    $encrypted = $crypter->encrypt('Secret');
} catch (Encrypt $e) {
    echo "Encryption failed: " . $e->getMessage();
}

try {
    $decrypted = $crypter->decrypt($encrypted);
} catch (Decrypt $e) {
    echo "Decryption failed: " . $e->getMessage();
}
```

## Key Length Validation

The constructor validates key length automatically:

* AES-128-CBC → 16 bytes
* AES-256-CBC → 32 bytes

If invalid, it throws:

```php
RuntimeException
```

## Security Notes

* Always store your encryption key securely.
* Never expose your key publicly.
* Rotate keys periodically if used in production.
* Do not modify encrypted payloads manually.

## Running Tests

```bash
composer install
composer test
```

## License

MIT