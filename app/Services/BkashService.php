<?php

namespace App\Services;

use GuzzleHttp\Client;
use Exception;

class BkashService
{
    protected $client;
    protected $baseUrl;
    protected $token;

    public function __construct()
    {
        $this->client = new Client();
        $this->baseUrl = env('BKASH_BASE_URL');
        $this->token = $this->getToken();
    }

    public function getToken()
    {
        try {
            $response = $this->client->post("{$this->baseUrl}/token/grant", [
                'json' => [
                    'app_key' => env('BKASH_APP_KEY'),
                    'app_secret' => env('BKASH_APP_SECRET'),
                ],
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            return $data['id_token'] ?? null;
        } catch (Exception $e) {
            throw new Exception('Failed to generate bKash token: ' . $e->getMessage());
        }
    }

    public function createPayment($amount, $callbackUrl)
    {
        try {
            $response = $this->client->post("{$this->baseUrl}/checkout/create", [
                'json' => [
                    'amount' => $amount,
                    'currency' => 'BDT',
                    'intent' => 'sale',
                    'merchantInvoiceNumber' => uniqid(),
                    'callbackURL' => $callbackUrl,
                ],
                'headers' => [
                    'Authorization' => $this->token,
                    'Content-Type' => 'application/json',
                ],
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (Exception $e) {
            throw new Exception('Failed to create payment: ' . $e->getMessage());
        }
    }

    public function executePayment($paymentId)
    {
        try {
            $response = $this->client->post("{$this->baseUrl}/checkout/execute", [
                'json' => [
                    'paymentID' => $paymentId,
                ],
                'headers' => [
                    'Authorization' => $this->token,
                    'Content-Type' => 'application/json',
                ],
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (Exception $e) {
            throw new Exception('Failed to execute payment: ' . $e->getMessage());
        }
    }
}
