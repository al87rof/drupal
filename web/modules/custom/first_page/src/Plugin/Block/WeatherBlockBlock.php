<?php

namespace Drupal\first_page\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\first_page\Services\Weather\WeatherService;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a weather block.
 *
 * @Block(
 *   id = "first_page_weather_block",
 *   admin_label = @Translation("Weather"),
 *   category = @Translation("Custom"),
 * )
 */
class WeatherBlockBlock extends BlockBase implements ContainerFactoryPluginInterface {

  protected $weatherService;

  public function __construct(
    array $configuration,
          $plugin_id,
          $plugin_definition,
    WeatherService $weatherService
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->weatherService = $weatherService;
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('first_page.weather_service')
    );
  }

  public function build() {
    $weather = $this->weatherService->getWeather();

    return [
      '#markup' => '
        <div class="weather-block">
          <p>Температура: ' . $weather['temp'] . '°C</p>
          <p>Погода: ' . $weather['description'] . '</p>
        </div>
      ',
      '#cache' => [
        'max-age' => 3600
      ],
    ];
  }
}
