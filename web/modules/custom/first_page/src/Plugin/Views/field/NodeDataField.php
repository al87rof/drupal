<?php

namespace Drupal\first_page\Plugin\views\field;

use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;

/**
 * A field that outputs node title and creation date.
 *
 * @ViewsField("node_data_field")
 */
class NodeDataField extends FieldPluginBase {

  public function query() {
    // Не нужно добавлять в запрос, используем существующие поля
  }

  public function render(ResultRow $values) {
    // Получаем ID ноды
    $nid = $values->nid;

    if (!$nid) {
      return '';
    }

    // Загружаем ноду
    $node = \Drupal::entityTypeManager()
      ->getStorage('node')
      ->load($nid);

    if (!$node) {
      return '';
    }

    // Получаем название и дату
    $title = $node->getTitle();
    $created = \DateTime::createFromFormat(
      'U',
      $node->getCreatedTime()
    )->format('d.m.Y H:i');

    return $title . ' (' . $created . ')';
  }
}
