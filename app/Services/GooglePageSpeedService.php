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
        // Preparar la URL para la consulta
        $categoriesParam = implode('&category=', $categories);
        $apiUrl = "https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url={$url}&key={$this->apiKey}&category={$categoriesParam}&strategy={$strategy}";
        try {
            // Realizar la solicitud
            $response = $this->client->get($apiUrl);
            $data = json_decode($response->getBody()->getContents(), true);

            // Extraer las métricas necesarias de `lighthouseResult.categories`
            $metrics = [];
            if (isset($data['lighthouseResult']['categories'])) {
                foreach ($data['lighthouseResult']['categories'] as $key => $category) {
                        // Guardamos el nombre y el puntaje de cada métrica relevante
                        $metrics[$category['title']] = $category['score'] * 100; // Convertimos el score a porcentaje
                }
            }

            return $metrics;
        } catch (\Exception $e) {
            \Log::error('error fetching metrics'. $e->getMessage());
            throw new \Exception('Error fetching metrics from Google API');
        }
    }

}
