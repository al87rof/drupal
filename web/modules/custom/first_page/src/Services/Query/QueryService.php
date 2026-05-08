<?php

namespace Drupal\first_page\Services\Query;

use Drupal\Core\Entity\EntityTypeManagerInterface;

class QueryService {

  public function  __construct(private readonly EntityTypeManagerInterface $entityTypeManager)
  {
  }


  public function countNodesByType(string $type): int {
    return $this->entityTypeManager->getStorage('node')->getQuery()
      ->condition('type', $type)
      ->condition('status', 1)
      ->accessCheck(TRUE)
      ->count()
      ->execute();
  }
}
