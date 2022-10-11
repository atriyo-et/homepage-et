<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;

class CaptchaService
{
    public function captchaVerify(string $recaptcha): bool
    {
        $client = HttpClient::create();
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $response = $client->request('POST', $url, [
            'body' => [
                'secret' => $_ENV['RECAPTCHA_SECRET'],
                'response' => $recaptcha,
                'remoteip' => $_SERVER['REMOTE_ADDR'],
            ],
        ]);

        return boolval($response->toArray()['success']);
    }
}
