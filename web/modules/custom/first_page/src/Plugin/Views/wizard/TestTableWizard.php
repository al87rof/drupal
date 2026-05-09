<?php

namespace Drupal\first_page\Plugin\views\wizard;

use Drupal\views\Plugin\views\wizard\WizardPluginBase;

/**
 * Плагін Wizard для нашої кастомної таблиці test_table.
 *
 * @ViewsWizard(
 *   id = "test_table_wizard",
 *   base_table = "test_table",
 *   title = @Translation("Test Table Items (Wizard)")
 * )
 */
class TestTableWizard extends WizardPluginBase {

  /**
   * Визначає налаштування відображення за замовчуванням при створенні в'юшки.
   */
  protected function defaultDisplayOptions() {

    $display_options = parent::defaultDisplayOptions();
    unset($display_options['fields']);


    $display_options['fields']['id'] = [
      'id' => 'id',
      'table' => 'test_table',
      'field' => 'id',
      'plugin_id' => 'numeric',
      'entity_type' => NULL,
      'entity_field' => NULL,
    ];


    $display_options['fields']['nid'] = [
      'id' => 'id',
      'table' => 'test_table',
      'field' => 'nid',
      'plugin_id' => 'numeric',
      'entity_type' => NULL,
      'entity_field' => NULL,
    ];

    $display_options['fields']['data'] = [
      'id' => 'data',
      'table' => 'test_table',
      'field' => 'data',
      'plugin_id' => 'standard',
      'entity_type' => NULL,
      'entity_field' => NULL,
    ];


    $display_options['fields']['status'] = [
      'id' => 'status',
      'table' => 'test_table',
      'field' => 'status',
      'plugin_id' => 'boolean',
      'entity_type' => NULL,
      'entity_field' => NULL,
    ];


    $display_options['style']['type'] = 'table';
    $display_options['style']['options'] = [
      'columns' => [
        'id' => 'id',
        'data' => 'data',
        'status' => 'status',
      ],
      'default' => 'id',
      'info' => [],
    ];

    return $display_options;
  }
}
