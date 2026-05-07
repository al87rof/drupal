<?php

namespace Drupal\first_page\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Listens to the dynamic route events.
 */
class RouteSubscriber extends RouteSubscriberBase {

  /**
   * {@inheritdoc}
   */
  protected function alterRoutes(RouteCollection $collection) {
    \Drupal::messenger()->addMessage('Subscriber работает!');
    // Пытаемся найти роут стандартной View главной страницы
    // или роут, который назначен главной в системе
    $front_route_name = \Drupal::config('system.site')->get('page.front');

    // Если там что-то вроде /node/1, нужно найти имя роута для этого пути
    // Но проще всего пройтись по коллекции и найти путь '/'
    foreach ($collection->all() as $name => $route) {
      if ($route->getPath() == '/') {
        $route->setDefault('_controller', '\Drupal\first_page\Controller\FirstPageController::frontPage');
      }
    }
  }
}
