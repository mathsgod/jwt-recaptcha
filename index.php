<?
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

use R\ReCaptcha;

require_once(__DIR__ . "/vendor/autoload.php");

$secret = uniqid();
$re = new ReCaptcha($secret,  [
    "charset" => "1234567890",
    "code_length" => 4,
    "num_lines" => 1,
    "perturbation" => 0.5
]);

print_r($re->hash());


echo $re->getCode();
