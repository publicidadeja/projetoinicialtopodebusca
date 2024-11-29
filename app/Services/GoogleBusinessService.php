<?php

namespace App\Services;

use Google\Client;
use Illuminate\Support\Facades\Log;

class GoogleBusinessService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
        $this->client->setClientId(config('services.google.client_id'));
        $this->client->setClientSecret(config('services.google.client_secret'));
        
        $this->client->addScope([
            'https://www.googleapis.com/auth/business.manage',
            'https://www.googleapis.com/auth/plus.business.manage',
            'https://www.googleapis.com/auth/places'
        ]);
    }

    public function setAccessToken($token)
    {
        $this->client->setAccessToken($token);
        
        if ($this->client->isAccessTokenExpired()) {
            if ($refresh_token = $this->client->getRefreshToken()) {
                $this->client->fetchAccessTokenWithRefreshToken($refresh_token);
            }
        }
    }

    public function getAccounts()
    {
        try {
            // Usando a Places API
            $url = 'https://places.googleapis.com/v1/places:searchText';
            $response = $this->client->getHttpClient()->post($url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->client->getAccessToken()['access_token'],
                    'Content-Type' => 'application/json',
                    'X-Goog-FieldMask' => 'places.displayName,places.formattedAddress,places.id'
                ],
                'json' => [
                    'textQuery' => auth()->user()->name // Busca pelo nome da empresa
                ]
            ]);
            
            $result = json_decode($response->getBody()->getContents(), true);
            
            if (isset($result['places'])) {
                return ['accounts' => $result['places']];
            }
            
            return ['accounts' => []];

        } catch (\Exception $e) {
            $error = json_decode($e->getMessage(), true);
            if ($error) {
                return ['error' => $error];
            }
            return ['error' => $e->getMessage()];
        }
    }
}