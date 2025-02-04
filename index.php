<?php
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

$hash=$re->hash();


//echo $re->getCode();
?>

<html>
    <head>
        <title>ReCaptcha</title>
    </head>
    <body>
        <img src="<?php echo $hash['image']; ?>" />
        <form method="post">
            <input type="text" name="code" />
            <input type="hidden" name="token" value="<?php echo $hash['token']; ?>" />
            <input type="submit" />
        </form>
    </body>
</html>



