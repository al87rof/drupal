<?php declare(strict_types = 1);

namespace Drupal\first_page\Controller;

use Drupal\Core\Controller\ControllerBase;
use JetBrains\PhpStorm\ArrayShape;

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


  #[ArrayShape(['#theme' => "string", '#title' => "string", '#content' => "string"])]
  public function firstPage(){

    $currentDate = new \DateTime();
    $formattedDate = $currentDate->format('d.m.Y H:i');
    $titleDate = $currentDate->format('d.m.Y');
    return [
      '#theme' => 'first_page',
      '#title' => "$titleDate — Моя перша стаття",
      '#content' => "поточна дата/час: $formattedDate",
    ];
  }

}
