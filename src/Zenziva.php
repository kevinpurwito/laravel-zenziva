<?php

namespace Kevinpurwito\LaravelZenziva;

use GuzzleHttp\Client;

class Zenziva
{
    public const GSM = 'gsm';
    public const CONSOLE = 'console';
    public const MAX_SMS = 400;
    public const MIN_OTP = 4;
    public const MAX_OTP = 8;
    public const MAX_WA = 1000;
    public const MAX_VOICE = 250;

    protected string $url = 'https://console.zenziva.net';
    protected string $pathSms = '/reguler/api/sendsms/';
    protected string $pathWa = '/wareguler/api/sendWA/';
    protected string $pathWaFile = '/wareguler/api/sendWAFile/';
    protected string $pathVoice = '/voice/api/sendvoice/';
    protected string $pathOtp = '/otp/api/sendOTP';
    protected string $type = self::CONSOLE;
    protected string $pTo = 'to';
    protected string $pMessage = 'message';
    protected string $userkey;
    protected string $passkey;

    protected Client $client;

    public function __construct($userkey, $passkey, $type = 'console')
    {
        $this->client = new Client();
        $this->type = $type;
        $this->url = 'https://' . $this->type . '.zenziva.net';
        $this->userkey = $userkey;
        $this->passkey = $passkey;

        if ($this->type == self::GSM) {
            $this->pTo = 'nohp';
            $this->pMessage = 'pesan';
            $this->pathSms = '/api/sendsms/';
            $this->pathOtp = '/api/sendOTP/';
            $this->pathWa = '/api/sendWA/';
            $this->pathWaFile = '/api/sendWAFile/';
            $this->pathVoice = '/api/sendWAFile/';
        }
    }

    public function getBalance()
    {
        $response = $this->balance();
        if ($this->type == self::GSM) {
            return json_decode($response->getBody())->credit ?? 0;
        }
        // console type
        return json_decode($response->getBody())->balance ?? 0;
    }

    public function balance()
    {
//        Example Response
//        {
//            "credit": "999999",
//            "expired": "31 Desember 2020",
//            "status": "1",
//            "text": "Success"
//        }
        return $this->client->get($this->url . '/api/balance/?userkey=' . $this->userkey . '&passkey=' . $this->passkey);
    }

//        Example Response
//        {
//            "messageId":"157365",
//            "to":"081111111111",
//            "status":"1",
//            "text":"Success"
//        }

    public function sendSms($phoneNo, $message)
    {
        $params = [
            'userkey' => $this->userkey,
            'passkey' => $this->passkey,
            $this->pTo => $phoneNo,
            $this->pMessage => substr($message, 0, self::MAX_SMS),
        ];

        return $this->client->request('POST', $this->url . $this->pathSms, ['json' => $params]);
    }

    public function sendWa($phoneNo, $message)
    {
        $params = [
            'userkey' => $this->userkey,
            'passkey' => $this->passkey,
            $this->pTo => $phoneNo,
            $this->pMessage => substr($message, 0, self::MAX_WA),
        ];

        return $this->client->request('POST', $this->url . $this->pathWa, ['json' => $params]);
    }

    public function sendWaFile($phoneNo, $message, $fileUrl)
    {
        $params = [
            'userkey' => $this->userkey,
            'passkey' => $this->passkey,
            $this->pTo => $phoneNo,
            'link' => $fileUrl, // .doc .pdf .xls .xlsx .csv .gif .jpg .mp4 .mp3
            'caption' => substr($message, 0, self::MAX_WA),
        ];

        return $this->client->request('POST', $this->url . $this->pathWaFile, ['json' => $params]);
    }

    // GSM Type Only Feature
    public function sendOtp($phoneNo, $otp)
    {
        if (! $this->type == self::GSM) {
            return null;
        }
        $params = [
            'userkey' => $this->userkey,
            'passkey' => $this->passkey,
            $this->pTo => $phoneNo,
            'kode_otp' => str_pad(substr($otp, 0, self::MAX_OTP), self::MIN_OTP, '0', STR_PAD_LEFT),
        ];

        return $this->client->request('POST', $this->url . $this->pathOtp, ['json' => $params]);
    }

    // Console Type Only Feature
    // Untuk mengirim Voice OTP, pisahkan kode OTP dengan spasi. Contoh: 8 5 6 9 7 8
    // Untuk mengirim Voice bilangan atau nominal, gunakan Rp diikuti bilangan/nominal tanpa spasi dan titik. Contoh: Rp1000000
    public function sendVoice($phoneNo, $message)
    {
        if (! $this->type == self::CONSOLE) {
            return null;
        }
        $params = [
            'userkey' => $this->userkey,
            'passkey' => $this->passkey,
            $this->pTo => $phoneNo,
            $this->pMessage => substr($message, 0, self::MAX_VOICE),
        ];

        return $this->client->request('POST', $this->url . $this->pathVoice, ['json' => $params]);
    }
}
