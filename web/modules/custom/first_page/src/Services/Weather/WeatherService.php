<?php

namespace Drupal\first_page\Services\Weather;

use GuzzleHttp\ClientInterface;
use Drupal\Core\Cache\CacheBackendInterface;

class WeatherService {

  protected $httpClient;
  protected $cacheBackend;

  const API_KEY = '3a94be2c9e24126344093c23292a811a';
  const CACHE_ID = 'first_page';
  const CACHE_TTL = 3600;

  public function __construct(
    ClientInterface $httpClient,
    CacheBackendInterface $cacheBackend
  ) {
    $this->httpClient = $httpClient;
    $this->cacheBackend = $cacheBackend;
  }

  /**
   * Get weather data
   */
  public function getWeather($latitude = 50.2646, $longitude = 28.6599) {

    $cache = $this->cacheBackend->get(self::CACHE_ID);

    if ($cache && $cache->data) {
      return $cache->data;
    }

    try {

      $response = $this->httpClient->get('https://api.openweathermap.org/data/2.5/weather', [
        'query' => [
          'lat' => $latitude,
          'lon' => $longitude,
          'appid' => self::API_KEY,
          'units' => 'metric',
        ],
      ]);

      $data = json_decode($response->getBody(), TRUE);

      $weather = [
        'temp' => $data['main']['temp'] ?? 0,
        'description' => $data['weather'][0]['description'] ?? 'Unknown',
        'icon' => $data['weather'][0]['icon'] ?? '01d',
      ];

      $this->cacheBackend->set(
        self::CACHE_ID,
        $weather,
        \Drupal::time()->getRequestTime() + self::CACHE_TTL
      );

      return $weather;

    } catch (\Exception $e) {
      return [
        'temp' => 0,
        'description' => 'Error: ' . $e->getMessage(),
        'icon' => '01d',
      ];
    }
  }
}
