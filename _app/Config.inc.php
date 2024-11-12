<?php
define("CONFIGURATION_DIRECTORY", __DIR__);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

error_reporting(E_ALL);

$config_data = file_get_contents(__DIR__."/config.json");
$config_array = json_decode($config_data, true);

//MYSQL configurations 
define('MYSQL_CONFIG', $config_array["database_homologation"]);
date_default_timezone_set('America/Sao_Paulo');

$dataHoraAtual = new DateTime();
$dataAtual = $dataHoraAtual->format('Y-m-d');
$horaAtual = $dataHoraAtual->format('H:i:s');

define("currentDate", $dataAtual);
define("currentTime", $horaAtual);

$mail_conf = $config_array['email'];

define('MAILUSER', $mail_conf['MAILUSER']);
define('MAILPASS', $mail_conf['MAILPASS']);
define('MAILPORT', $mail_conf['MAILPORT']);
define('MAILHOST', $mail_conf['MAILHOST']);
define('FROM_NAME', $mail_conf['FROM_NAME']);
define('FROM_EMAIL', $mail_conf['FROM_EMAIL']);

// function generateVerificationCode($length = 6) {
//     if ($length < 1) {
//         throw new InvalidArgumentException("O tamanho deve ser pelo menos 1.");
//     }

//     // Define o valor mínimo e máximo de acordo com o tamanho
//     $min = pow(10, $length - 1); // Exemplo: se $length for 3, $min será 100
//     $max = pow(10, $length) - 1; // Exemplo: se $length for 3, $max será 999

//     return strval(random_int($min, $max));
// }


$BASE_URL = "https://" . $_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI'] . "?") . "/";

define("SITE", "https://" . $_SERVER['SERVER_NAME'] . "/escritorio");

