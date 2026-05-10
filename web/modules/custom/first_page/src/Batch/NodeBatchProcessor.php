<?php

namespace Drupal\first_page\Batch;

class NodeBatchProcessor {

  /**
   * Process single node
   */
  public static function processNode($nid, &$context) {

    $node = \Drupal::entityTypeManager()
      ->getStorage('node')
      ->accessCheck(TRUE)
      ->load($nid);

    if ($node) {
      $node->save();

      $context['message'] = t('Processing node @nid: @title', [
        '@nid' => $nid,
        '@title' => $node->getTitle(),
      ]);
    }
  }

  /**
   * Callback when batch finished
   */
  public static function finished($success, $results, $operations) {
    if ($success) {
      \Drupal::messenger()->addMessage(t('Batch operations completed!'));
    } else {
      \Drupal::messenger()->addError(t('Batch operations failed!'));
    }
  }
}
