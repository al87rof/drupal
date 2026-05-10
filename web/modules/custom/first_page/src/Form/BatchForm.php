<?php

namespace Drupal\first_page\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class BatchForm extends FormBase {

  public function getFormId() {
    return 'batch_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => t('Run Batch Operations'),
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $nids = \Drupal::entityQuery('node')
      ->condition('type', 'article')->accessCheck(FALSE)
      ->execute();


    $operations = [];

    foreach ($nids as $nid) {
      $operations[] = [
        '\Drupal\my_module\Batch\NodeBatchProcessor::processNode',
        [$nid],
      ];
    }


    $batch = [
      'title' => t('Processing nodes'),
      'operations' => $operations,
      'finished' => '\Drupal\my_module\Batch\NodeBatchProcessor::finished',
    ];

    batch_set($batch);
  }
}
