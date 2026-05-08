<?php

/**
 * Implements hook_views_data().
 */
function first_page_views_data() {
  $data['views']['node_custom_info'] = [
    'title' => t('Название ноды и дата создания (кастомное)'),
    'help' => t('Выводит комбинированную строку: Заголовок + Дата.'),
    'field' => [
      'id' => 'node_data_field',
    ],
  ];
  return $data;
}
