<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

use PHPUnit\Framework\TestCase;
use R\ReCaptcha;

class ReCaptchaTest extends TestCase
{
    public function testCreate()
    {
        $secret = uniqid();
        $re = new ReCaptcha($secret);
        $this->assertInstanceOf(ReCaptcha::class, $re);
    }

    public function testHash()
    {
        $secret = uniqid();
        $re = new ReCaptcha($secret);
        $hash = $re->hash();

        $code = $re->getCode();
        $this->assertArrayHasKey("token", $hash);
        $this->assertArrayHasKey("image", $hash);


        $re2 = new ReCaptcha($secret);
        $this->assertTrue($re2->verify($code, $hash["token"]));
        $this->assertFalse($re2->verify("123123", $hash["token"]));
    }

    public function test_other()
    {
        $secret = uniqid();
        $re = new ReCaptcha($secret, [
            "charset" => "1234567890",
            "code_length" => 4,
            "num_lines" => 1,
            "perturbation" => 0.5
        ]);
        $hash = $re->hash();

        $code = $re->getCode();
        $this->assertArrayHasKey("token", $hash);
        $this->assertArrayHasKey("image", $hash);

        $re2 = new ReCaptcha($secret);
        $this->assertTrue($re2->verify($code, $hash["token"]));
        $this->assertFalse($re2->verify("abcd", $hash["token"]));
    }
}
