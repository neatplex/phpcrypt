<?php

namespace MiladRahimi\PhpCrypt\Tests;

use MiladRahimi\PhpCrypt\Base64\SafeBase64Parser;
use MiladRahimi\PhpCrypt\Exceptions\CipherMethodNotSupportedException;
use MiladRahimi\PhpCrypt\Exceptions\DecryptionException;
use MiladRahimi\PhpCrypt\Exceptions\EncryptionException;
use MiladRahimi\PhpCrypt\Symmetric;
use PHPUnit\Framework\TestCase;

class SymmetricTest extends TestCase
{
    /**
     * @throws EncryptionException
     * @throws DecryptionException
     */
    public function test_encrypt_and_decrypt_without_key_and_iv()
    {
        $symmetric = new Symmetric();
        $result = $symmetric->encrypt('secret');

        $this->assertEquals('secret', $symmetric->decrypt($result));
    }

    /**
     * @throws EncryptionException
     * @throws DecryptionException
     */
    public function test_encrypt_and_decrypt_with_custom_key()
    {
        $symmetric = new Symmetric();
        $symmetric->generateKey();
        $result = $symmetric->encrypt('secret');

        $this->assertEquals('secret', $symmetric->decrypt($result));
    }

    /**
     * @throws EncryptionException
     * @throws DecryptionException
     */
    public function test_encrypt_and_decrypt_with_custom_iv()
    {
        $symmetric = new Symmetric();
        $symmetric->generateIv();
        $result = $symmetric->encrypt('secret');

        $this->assertEquals('secret', $symmetric->decrypt($result));
    }

    public function test_set_and_get_options()
    {
        $symmetric = new Symmetric();

        $symmetric->setOptions(OPENSSL_ZERO_PADDING);
        $this->assertEquals(OPENSSL_ZERO_PADDING, $symmetric->getOptions());
    }

    public function test_set_and_get_key()
    {
        $symmetric = new Symmetric();

        $symmetric->setKey('key');
        $this->assertEquals('key', $symmetric->getKey());
    }

    public function test_set_and_get_iv()
    {
        $symmetric = new Symmetric();

        $symmetric->setIv('iv');
        $this->assertEquals('iv', $symmetric->getIv());
    }

    public function test_set_and_get_base64_parser()
    {
        $symmetric = new Symmetric();

        $parser = new SafeBase64Parser();
        $symmetric->setBase64Parser($parser);
        $this->assertSame($parser, $symmetric->getBase64Parser());
    }

    public function test_supportedMethods()
    {
        $symmetric = new Symmetric();

        $methods = $symmetric->supportedMethods();
        $this->assertIsArray($methods);
    }

    /**
     * @throws CipherMethodNotSupportedException
     */
    public function test_set_and_get_method()
    {
        $symmetric = new Symmetric();

        $method = $symmetric->supportedMethods()[0];
        $symmetric->setMethod($method);
        $this->assertEquals($method, $symmetric->getMethod());
    }
}
