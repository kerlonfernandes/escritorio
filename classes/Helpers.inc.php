<?php

namespace HelpersClass;

use DateTime;

class SupAid
{
    public static function CreateResponse($type = "success", $message = "", $status_code = 1010)
    {
        $response = array();
        if ($type == "error") {
            $response['status'] = 'error';
            $response['message'] = $message;
            $response['error'] = true;
            $response['status_code'] = $status_code;
        } else {
            $response['status'] = 'success';
            $response['message'] = $message;
            $response['error'] = false;
            $response['status_code'] = 200;
        }

        return json_encode($response);
    }
    public function getCurrentDate()
    {
        date_default_timezone_set('America/Sao_Paulo'); // Configura o fuso horário para Brasília (BRT)
        return date("Y-m-d");
    }

    public function getCurrentTime()
    {
        date_default_timezone_set('America/Sao_Paulo');
        return date("H:i:s");
    }
    public function getCurrentDateTime()
    {
        date_default_timezone_set('America/Sao_Paulo');
        return date("Y-m-d H:i:s");
    }
    public function generateNumKey($len, $min, $max)
    {
        $sequence = array();

        for ($i = 0; $i < $len; $i++) {
            $sequence[] = rand($min, $max);
        }
        return $sequence;
    }

    public function generateRandomLetterHash($length = 20)
    {
        $letters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lettersLength = strlen($letters);
        $hash = '';

        for ($i = 0; $i < $length; $i++) {
            $randomIndex = rand(0, $lettersLength - 1);
            $hash .= $letters[$randomIndex];
        }

        return $hash;
    }

    public function validateEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public function validatePhoneNumber($phoneNumber)
    {
        return preg_match("/^\d{10}$/", $phoneNumber);
    }

    public function sanitizeInput($input)
    {
        return htmlspecialchars(strip_tags(trim($input)));
    }

    public function generateRandomPassword($length = 8)
    {
        return substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $length);
    }

    public function sendEmail($to, $subject, $message, $headers)
    {
        return mail($to, $subject, $message, $headers);
    }

    public function calculateAge($birthDate)
    {
        $today = new DateTime();
        $birthdate = new DateTime($birthDate);
        $age = $today->diff($birthdate);
        return $age->y;
    }



    function createSlug($str)
    {

        $username = $this->removeAccents($str);

        $cleaned = preg_replace('/[^a-zA-Z0-9]+/', '-', $username);

        $lowercase = strtolower($cleaned);

        $slug = preg_replace('/-+/', '-', $lowercase);

        $slug = trim($slug, '-');

        return $slug;
    }

    function removeAccents($str)
    {
        $str = mb_strtolower($str, 'UTF-8');
        $str = str_replace(
            ['á', 'à', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'é', 'è', 'ê', 'ë', 'í', 'ì', 'î', 'ï', 'ñ', 'ó', 'ò', 'ô', 'õ', 'ö', 'ø', 'ú', 'ù', 'û', 'ü'],
            ['a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u'],
            $str
        );
        $str = preg_replace('/[^a-z0-9\-]+/', '-', $str);
        return $str;
    }

    ///////////// ENCODE URL /////////////////////
    function encodeURL($str)
    {
        $prfx = array(
            'AFVxaIF',
            'Vzc2ddS',
            'ZEca3d1',
            'aOdhlVq',
            'QhdFmVJ',
            'VTUaU5U',
            'QRVMuiZ',
            'lRZnhnU',
            'Hi10dX1',
            'GbT9nUV',
            'TPnZGZz',
            'ZGiZnZG',
            'dodHJe5',
            'dGcl0NT',
            'Y0NeTZy',
            'dGhnlNj',
            'azc5lOD',
            'BqbWedo',
            'bFmR0Mz',
            'Q1MFjNy',
            'ZmFMkdm',
            'dkaDIF1',
            'hrMaTk3',
            'aGVFsbG'
        );
        for ($i = 0; $i < 3; $i++) {
            $str = $prfx[array_rand($prfx)] . strrev(base64_encode($str));
        }
        $str = strtr($str, "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789", "a8rqxPtfiNOlYFGdonMweLCAm0TXERcugBbj79yDVIWsh3Z5vHS46pQzKJ1Uk2");
        return $str;
    }

    ///////////// DECODE URL /////////////////////
    function decodeURL($str)
    {
        $str = strtr($str, "a8rqxPtfiNOlYFGdonMweLCAm0TXERcugBbj79yDVIWsh3Z5vHS46pQzKJ1Uk2", "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789");
        for ($i = 0; $i < 3; $i++) {
            $str = base64_decode(strrev(substr($str, 7)));
        }
        return $str;
    }

    function encryptQueryString($data, $key)
    {
        $cipher = "AES-256-CBC";
        $iv_length = openssl_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes($iv_length);
        $encrypted = openssl_encrypt(http_build_query($data), $cipher, $key, 0, $iv);
        return base64_encode($iv . $encrypted);
    }

    // Função para descriptografar a query string
    function decryptQueryString($data, $key)
    {
        $cipher = "AES-256-CBC";
        $iv_length = openssl_cipher_iv_length($cipher);
        $data = base64_decode($data);
        $iv = substr($data, 0, $iv_length);
        $data = substr($data, $iv_length);
        parse_str(openssl_decrypt($data, $cipher, $key, 0, $iv), $output);
        return $output;
    }

    // usage example
    // // Dados para a query string
    // $data = array('param1' => 'valor1', 'param2' => 'valor2');

    // // Chave para criptografia (deve ser mantida em segredo)
    // $key = "chave_secreta_muito_forte"; // Use uma chave suficientemente longa e segura

    // // Codificar a query string
    // $queryString = encryptQueryString($data, $key);
    // echo "Query String criptografada: " . $queryString . "<br>";

    // // Decodificar a query string
    // $decryptedData = decryptQueryString($queryString, $key);
    // echo "Dados decodificados: <pre>";
    // print_r($decryptedData);
    // echo "</pre>";

    public function fileExists($filePath)
    {
        return file_exists($filePath);
    }

    public function sortAssocArrayByValue($array)
    {
        asort($array);
        return $array;
    }

    public function sumArray($array)
    {
        return array_sum($array);
    }

    public function redirect($url)
    {
        header("Location: $url");
        exit();
    }

    public function hashPassword($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public function verifyPassword($password, $hashedPassword)
    {
        return password_verify($password, $hashedPassword);
    }
}
