<?
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

        $this->assertTrue($re->verify($hash["token"], $code));
        $this->assertFalse($re->verify($hash["token"], uniqid()));
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

        $this->assertTrue($re->verify($hash["token"], $code));
        $this->assertFalse($re->verify($hash["token"], uniqid()));
    }
}
