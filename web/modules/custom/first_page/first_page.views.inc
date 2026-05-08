<?php

/**
 * Implements hook_views_data().
 */
function first_page_views_data() {
  $data = [];

  $data['test_table']['table']['group'] = 'Custom Table';

  $data['test_table']['table']['base'] = [
    'field' => 'id',
    'title' => t('Items from test_table'),
    'help' => t('Show list items from test_table.'),
  ];

  // Join with node table.
  $data['test_table']['table']['join'] = [
    'node_field_data' => [
      'left_field' => 'nid',
      'field' => 'nid',
    ],
  ];

  $data['test_table']['id'] = [
    'title' => t('ID'),
    'field' => [
      'id' => 'numeric',
    ],
    'sort' => [
      'id' => 'standard',
    ],
    'filter' => [
      'id' => 'numeric',
    ],
  ];

  $data['test_table']['nid'] = [
    'title' => t('Node ID'),
    'field' => [
      'id' => 'numeric',
    ],
    'sort' => [
      'id' => 'standard',
    ],
    'filter' => [
      'id' => 'numeric',
    ],
  ];

  $data['test_table']['data'] = [
    'title' => t('Data'),
    'help' => t('Custom data field'),
    'field' => [
      'id' => 'standard',
    ],
    'sort' => [
      'id' => 'standard',
    ],
    'filter' => [
      'id' => 'string',
    ],
  ];

  $data['test_table']['status'] = [
    'title' => t('Status'),
    'field' => [
      'id' => 'boolean',
    ],
    'sort' => [
      'id' => 'standard',
    ],
    'filter' => [
      'id' => 'boolean',
    ],
  ];

  // Custom field.
  $data['test_table']['node_custom_info'] = [
    'title' => t('Node name and date created'),
    'help' => t('Show concat string: Title + Datetime'),
    'field' => [
      'id' => 'node_data_field',
    ],
  ];

  return $data;
}
