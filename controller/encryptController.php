<?php
class SimpleEncrypt
{
    private $clave;
    private $metodo;

    public function __construct($clave) {
        $this->clave = $clave; // Secret key
        $this->metodo = 'AES-256-CBC'; // Encryption method
    }

    public function encriptar($datos) {
        $iv_length = openssl_cipher_iv_length($this->metodo); // Get the correct IV length
        $iv = openssl_random_pseudo_bytes($iv_length); // Generate IV with the correct length
        $encrypted = openssl_encrypt($datos, $this->metodo, $this->clave, 0, $iv);
        return base64_encode($encrypted . '::' . $iv); // Return encrypted data with IV
    }

    public function desencriptar($datos_encriptados) {
        list($encrypted_data, $iv) = explode('::', base64_decode($datos_encriptados), 2); // Split encrypted data and IV
        $iv_length = openssl_cipher_iv_length($this->metodo); // Ensure correct IV length
        if (strlen($iv) !== $iv_length) {
            // Pad IV if necessary to make it the correct length
            $iv = str_pad($iv, $iv_length, "\0");
        }
        return openssl_decrypt($encrypted_data, $this->metodo, $this->clave, 0, $iv); // Decrypt using the correct IV
    }
}


?>
