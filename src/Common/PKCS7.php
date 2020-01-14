<?php

namespace Omnipay\CreditCardPaymentProcessor\Common;

use Exception;

class PKCS7
{
    public static function encrypt($content, $publicKey, $tmpDir = null)
    {
        if (!$tmpDir) {
            $path = function_exists('storage_path') ? storage_path('tmp/') : dirname(__FILE__);
            $tmpDir = tempnam($path, '2c2p_pkcs7_');
        }

        $filename = $tmpDir;
        $filenameEnc = $tmpDir . '.enc';

        if (file_put_contents($filename, $content) == false) {
            throw new Exception("Cannot put contents into file ($filename)." . var_export(file_put_contents($filename, $content), true) . var_export($content, true));
        }

        if (is_file($publicKey)) {
            if (!($_publicKey = file_get_contents($publicKey))) {
                throw new Exception("Cannot get public key from file ($publicKey).");
            }
            $publicKey = $_publicKey;
        }

        if (openssl_pkcs7_encrypt($filename, $filenameEnc, $publicKey, [])) {
            unlink($filename);
            if (!($content = file_get_contents($filenameEnc))) {
                throw new Exception("Cannot get encrypted content from file ($filenameEnc).");
            }
            unlink($filenameEnc);

            $content = str_replace(
                <<<EOF
MIME-Version: 1.0
Content-Disposition: attachment; filename="smime.p7m"
Content-Type: application/x-pkcs7-mime; smime-type=enveloped-data; name="smime.p7m"
Content-Transfer-Encoding: base64
EOF
                , '', $content);
            $content = str_replace("\n", '', $content);
            return $content;
        } else {
            unlink($filename);
            @unlink($filenameEnc);
        }

        return false;
    }

    public static function decrypt($content, $publicKey, $privateKey, $password, $tmpDir = null)
    {
        if (!$tmpDir) {
            $path = function_exists('storage_path') ? storage_path('tmp/') : dirname(__FILE__);
            $tmpDir = tempnam($path, '2c2p_pkcs7_');
        }

        $filename = $tmpDir;
        $filenameDec = $tmpDir . '.dec';

        $prefix = <<<EOF
MIME-Version: 1.0
Content-Disposition: attachment; filename="smime.p7m"
Content-Type: application/x-pkcs7-mime; smime-type=enveloped-data; name="smime.p7m"
Content-Transfer-Encoding: base64


EOF;
        $arr = str_split($content, 64);
        $content = implode("\n", $arr);
        $content = $prefix . $content;

        if (file_put_contents($filename, $content) == false) {
            throw new Exception("Cannot put contents into file ($filename).");
        }

        if (is_file($publicKey)) {
            if (!($_publicKey = file_get_contents($publicKey))) {
                throw new Exception("Cannot get public key from file ($publicKey).");
            }
            $publicKey = $_publicKey;
        }

        if (is_file($privateKey)) {
            if (!($_privateKey = file_get_contents($privateKey))) {
                throw new Exception("Cannot get private key from file ($privateKey).");
            }
            $privateKey = $_privateKey;
        }

        if (openssl_pkcs7_decrypt($filename, $filenameDec, $publicKey, [$privateKey, $password])) {
            unlink($filename);
            if (!($content = file_get_contents($filenameDec))) {
                throw new Exception("Cannot get decrypted content from file ($filenameDec).");
            }
            unlink($filenameDec);
            return $content;
        } else {
            unlink($filename);
            @unlink($filenameDec);
        }

        return false;
    }
}
