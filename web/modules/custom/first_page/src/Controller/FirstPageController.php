<?php declare(strict_types = 1);

namespace Drupal\first_page\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Returns responses for First page routes.
 */
final class FirstPageController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function __invoke(): array {

    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('It works!'),
    ];

    return $build;
  }



  public function firstPage(): array{

    $currentDate = new \DateTime();
    $formattedDate = $currentDate->format('d.m.Y H:i');
    $titleDate = $currentDate->format('d.m.Y');
    return [
      '#theme' => 'first_page',
      '#title' => "$titleDate — Моя перша стаття",
      '#content' => "поточна дата/час: $formattedDate",

      '#attached' => [
        'library' => ['first_page/clock'],
      ],

      '#cache' => [
        'max-age' => 0,
      ],
    ];
  }




  /**
   * Контент главной страницы.
   */
  public function frontPage() {
    $user = \Drupal::currentUser();

    if ($user->isAnonymous()) {
      throw new AccessDeniedHttpException();
    }else{
      return [
        '#markup' => '<h1>Добро пожаловать на главную страницу!</h1>',
      ];
    }
  }



  public function helloPage() {
    $config = \Drupal::config('system.site');
    $siteName = $config->get('name');

    return [
      '#theme' => 'my_hello',
      '#siteName' => $siteName,
    ];
  }



}
