<?php

namespace App\Utils;

use GuzzleHttp\Client;

class ReCaptcha
{
    /**
     * @var string
     */
    private $secret;

    private $verifyEndpoint = 'https://www.google.com/recaptcha/api/siteverify';

    public function __construct(string $secret)
    {
        $this->secret = $secret;
    }

    /**
     * Return if true of false the code is valid
     *
     * @param string $code
     * @return bool
     */
    public function validate(string $code): bool
    {
        $client = new Client(['http_errors' => false]);
        $response = $client->post($this->verifyEndpoint, [
            'form_params' => [
                'response' => $code,
                'secret' => $this->secret
            ]
        ]);
        if ($response->getStatusCode() === 200) {
            $parsedResponse = json_decode($response->getBody()->getContents(), true);

            return $parsedResponse['success'] === true;
        }
        return false;
    }
}
