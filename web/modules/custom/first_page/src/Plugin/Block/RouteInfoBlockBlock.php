<?php

namespace Drupal\first_page\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a route info block block.
 *
 * @Block(
 *   id = "first_page_route_info_block",
 *   admin_label = @Translation("Route Info Block"),
 *   category = @Translation("Custom"),
 * )
 */
final class RouteInfoBlockBlock extends BlockBase implements ContainerFactoryPluginInterface {

  protected $routeMatch;

  // Конструктор получает сервис
  public function __construct(array $configuration, $plugin_id, $plugin_definition, RouteMatchInterface $route_match) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->routeMatch = $route_match;
  }

  /**
   * {@inheritdoc}
   */
  public function build(): array {
    $route_name = $this->routeMatch->getRouteName();

    return [
      '#markup' => '<div class="current-route"><p>Current route: ' . $route_name . '</p></div>',

      '#cache' => [
        'keys' => ['current_route_block', $route_name],
        'contexts' => ['route'],
        'max-age' => 3600,
      ],
    ];
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
  {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('current_route_match')
    );
  }
}
