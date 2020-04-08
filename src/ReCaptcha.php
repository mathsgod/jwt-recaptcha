<?php

namespace R;

use Firebase\JWT\JWT;
use Securimage;

class ReCaptcha
{

    public $securimage;
    public $secret;
    public $expiry_time = 1800;
    public $code = "";

    public function __construct(string $secret, array $securimage_options = [])
    {
        $this->secret = $secret;

        $options = array_merge($securimage_options, [
            "no_session" => true,
            "send_headers" => false,
            "no_exit" => true
        ]);
        $this->securimage = new Securimage($options);
    }

    public function getCode()
    {
        return $this->code;
    }

    public function hash(): array
    {

        ob_start();
        $this->securimage->show();
        $content = ob_get_contents();
        ob_end_clean();

        $this->code = $this->securimage->getCode(false, true);

        $token = JWT::encode([
            "hash" => password_hash($this->code, PASSWORD_DEFAULT),
            "iat" => time(),
            "exp" => time() + $this->expiry_time
        ], $this->secret, "HS256");



        return [
            "token" => $token,
            "image" => "data:image/png;base64," . base64_encode($content)
        ];
    }

    public function verify(string $code, string $token): bool
    {
        $token = (array) JWT::decode($token, $this->secret, ["HS256"]);

        return password_verify($code, $token["hash"]);
    }
}
