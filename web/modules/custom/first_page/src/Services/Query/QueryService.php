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



  public function dumpEntity($entityType, $entityId) {
    try {
      $entity = $this->entityTypeManager
        ->getStorage($entityType)
        ->load($entityId);

      if (!$entity) {
        return "Entity not found: $entityType:$entityId";
      }


      $dump = [
        'Type' => $entityType,
        'ID' => $entityId,
        'Label' => $entity->label(),
        'UUID' => $entity->uuid(),
        'Bundle' => $entity->bundle(),
      ];


      foreach ($entity as $fieldName => $fieldItemList) {

        if (!$entity->get($fieldName)->access('view')) {
          continue;
        }


        $dump['Field: ' . $fieldName] = $fieldItemList->value ?? $fieldItemList->getString();
      }

      return $dump;

    } catch (\Exception $e) {
      return "Error: " . $e->getMessage();
    }
  }

}
