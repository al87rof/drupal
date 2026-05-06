<?php

use Drupal\node\Entity\Node;

$values = [
  'type'  => 'page',
  'title' => 'my first page',
  'langcode' => 'ru',
  'uid' => 1,
  'status' => 1,
  'body' => [
    'value' => 'body text',
    'format' => 'plain_text',
  ]
];


$node = Node::create($values);

$violations = $node->validate();

if ($violations->count() > 0) {
  foreach ($violations as $violation) {
    \Drupal::logger('my_module')->error($violation->getMessage());
  }
} else {

  $node->save();
  \Drupal::messenger()->addStatus('Node created ID: ' . $node->id());
}
