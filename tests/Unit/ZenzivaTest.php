<?php

namespace Kevinpurwito\LaravelZenziva\Tests\Unit;

use GuzzleHttp\Psr7\Response;
use Kevinpurwito\LaravelZenziva\Tests\TestCase;
use Kevinpurwito\LaravelZenziva\ZenzivaFacade as Zenziva;

class ZenzivaTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /** @test */
    public function it_has_credentials()
    {
        config([
            'kp_zenziva.type' => 'gsm',

            'kp_zenziva.userkey' => 'mock_user',

            'kp_zenziva.passkey' => 'mock_pass',
        ]);

        $this->assertTrue(config('kp_zenziva.type') == 'gsm');
        $this->assertTrue(config('kp_zenziva.userkey') == 'mock_user');
        $this->assertTrue(config('kp_zenziva.passkey') == 'mock_pass');
    }

    /** @test */
    public function it_has_balance()
    {
        $this->markTestIncomplete('This test has passed, skipping to conserve Zenziva balance.');

        $balance = Zenziva::getBalance();
        $this->assertTrue(is_numeric($balance));
    }

    /** @test */
    public function it_can_send_sms()
    {
        $this->markTestIncomplete('This test has passed, skipping to conserve Zenziva balance.');

        $phoneNo = env('KP_ZENZIVA_TEST_PHONE');

        /** @var Response $response */
        $response = Zenziva::sendSms($phoneNo, 'testing sms');
        $this->assertTrue($response->getStatusCode() == 201);

        $content = json_decode($response->getBody()->getContents());
        $this->assertTrue($content->status == '1');
        $this->assertTrue($content->text == 'Success');
    }

    /** @test */
    public function it_can_send_wa()
    {
        $this->markTestIncomplete('This test has passed, skipping to conserve Zenziva balance.');

        $phoneNo = env('KP_ZENZIVA_TEST_PHONE');

        /** @var Response $response */
        $response = Zenziva::sendWa($phoneNo, 'testing wa');
        $this->assertTrue($response->getStatusCode() == 201);

        $content = json_decode($response->getBody()->getContents());
        $this->assertTrue($content->status == '1');
        $this->assertTrue($content->text == 'Success');
    }

    /** @test */
    public function it_can_send_wa_file()
    {
        $this->markTestIncomplete('This test has passed, skipping to conserve Zenziva balance.');

        $phoneNo = env('KP_ZENZIVA_TEST_PHONE');
        $fileUrl = env('KP_ZENZIVA_TEST_FILE');

        /** @var Response $response */
        $response = Zenziva::sendWaFile($phoneNo, 'testing wa file', $fileUrl);
        $this->assertTrue($response->getStatusCode() == 201);

        $content = json_decode($response->getBody()->getContents());
        $this->assertTrue($content->status == '1');
        $this->assertTrue($content->text == 'Success');
    }

    /** @test */
    public function it_can_send_otp()
    {
        $this->markTestIncomplete('This test has passed, skipping to conserve Zenziva balance.');

        if (config('kp_zenziva.type') !== 'gsm') {
            $this->markTestIncomplete('Zenziva type is not GSM.');
        }

        $phoneNo = env('KP_ZENZIVA_TEST_PHONE');
        $otp = random_int(10000, 99999);

        /** @var Response $response */
        $response = Zenziva::sendOtp($phoneNo, $otp);
        $this->assertTrue($response->getStatusCode() == 201);

        $content = json_decode($response->getBody()->getContents());
        $this->assertTrue($content->status == '1');
        $this->assertTrue($content->text == 'Success');
    }

    /** @test */
    public function it_can_send_voice()
    {
        $this->markTestIncomplete('This test has passed, skipping to conserve Zenziva balance.');

        if (config('kp_zenziva.type') !== 'console') {
            $this->markTestIncomplete('Zenziva type is not Console.');
        }

        $phoneNo = env('KP_ZENZIVA_TEST_PHONE');
        $otp = random_int(10000, 99999);

        /** @var Response $response */
        $response = Zenziva::sendVoice($phoneNo, $otp);
        $this->assertTrue($response->getStatusCode() == 201);

        $content = json_decode($response->getBody()->getContents());
        $this->assertTrue($content->status == '1');
        $this->assertTrue($content->text == 'Success');
    }
}
