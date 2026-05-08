<?php

namespace Drupal\first_page\Plugin\QueueWorker;

use Drupal\Core\Queue\QueueWorkerBase;
use Drupal\node\Entity\Node;

/**
 * Processes Node update tasks.
 *
 * @QueueWorker(
 *   id = "node_update_worker",
 *   title = @Translation("Node Update Worker"),
 *   cron = {"time" = 30}
 * )
 */
class NodeUpdateWorker extends QueueWorkerBase {

  public function processItem($data) {
    $nid = $data['nid'];
    /** @var Node $node */
    $node = \Drupal::entityTypeManager()
      ->getStorage('node')
      ->load($nid);

    if (!$node) {
      return;
    }

    $lastChanged = $node->getChangedTime();
    $currentTime = \Drupal::time()->getRequestTime();
    $hoursPassed = ($currentTime - $lastChanged) / 3600;

    if ($hoursPassed > 24) {
      $node->setChangedTime($currentTime);
      $node->save();

      \Drupal::logger('my_module')->info(
        'Node @nid was resaved after @hours hours',
        ['@nid' => $nid, '@hours' => $hoursPassed]
      );
    }
  }
}
