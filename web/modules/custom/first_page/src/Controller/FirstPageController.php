<?php declare(strict_types = 1);

namespace Drupal\first_page\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\first_page\Services\Query\QueryService;
use Drupal\node\Entity\Node;
use Drupal\node\Plugin\views\argument\Type;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Returns responses for First page routes.
 */
final class FirstPageController extends ControllerBase {


  public function __construct(protected readonly QueryService $queryService) {}

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('first_page.query_service')
    );
  }


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



  public function countNodesPage() {
    $totalNodes = $this->queryService->countNodesByType('page');

    return [
      '#theme' => 'nodes_count',
      '#totalNodes' => $totalNodes,

      '#cache' => [
        'max-age' => 0,
      ],
    ];
  }


  public function dumpPage() {

    $dump = $this->queryService->dumpEntity('node', 1);

    $output = '<pre>' . print_r($dump, TRUE) . '</pre>';

    return [
      '#markup' => $output,
    ];
  }



}
