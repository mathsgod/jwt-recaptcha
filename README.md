# jwt-recaptcha
using jwt for recaptcha in php

## Server generate hash
```php
$secret="your secret key";

$re = new ReCaptcha($secret);
$hash = $re->hash();

echo $hash["token"]; //token sent to user, use for verify later
echo $hash["image"]; //recaptcha image

```

## Server verify recaptcha code
```php
$re = new ReCaptcha($secret);
$code;//get from user
$token;//get from user sent before

if($re->verify($code,$token)){
    //correct code
}else{
    //incorrect code 
}
```

### Demo
```php

$re = new ReCaptcha($secret,  [
    "charset" => "1234567890",
    "code_length" => 4,
    "num_lines" => 1,
    "perturbation" => 0.5
]);

$hash = $re->hash();
$image_src = $hash["image"];
```
<img src="https://raw.githubusercontent.com/mathsgod/jwt-recaptcha/refs/heads/master/demo/demo.png"/>






