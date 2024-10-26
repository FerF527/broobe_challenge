<?php

namespace App\Services;

use GuzzleHttp\Client;

class GooglePageSpeedService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client([
            'timeout' => 60,  
        ]);
        $this->apiKey = env('GOOGLE_API_KEY');
    }

    public function getMetrics($url, $categories, $strategy)
    {
        $categoriesParam = implode('&category=', $categories);
        $apiUrl = "https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url={$url}&key={$this->apiKey}&category={$categoriesParam}&strategy={$strategy}";

        try {
            $response = $this->client->request('GET', $apiUrl);
            $data = json_decode($response->getBody()->getContents(), true);

            return $data;
        } catch (\Exception $e) {
            throw new \Exception('Error fetching metrics from Google API');
        }
    }
}
