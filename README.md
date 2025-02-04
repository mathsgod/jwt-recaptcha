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






