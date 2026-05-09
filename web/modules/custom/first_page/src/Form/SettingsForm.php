<?php

namespace Drupal\first_page\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;

class SettingsForm extends ConfigFormBase {

  /**
   * Вказуємо назву об'єкта конфігурації.
   */
  protected function getEditableConfigNames() {
    return ['first_page.settings'];
  }

  public function getFormId() {
    return 'first_page_settings_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('first_page.settings');

    $form['enabled'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Увімкнено'),
      '#default_value' => $config->get('enabled'),
    ];

    $form['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Назва'),
      '#default_value' => $config->get('name'),
      '#required' => TRUE,
    ];

    $form['related_node'] = [
      '#type' => 'entity_autocomplete',
      '#target_type' => 'node',
      '#title' => $this->t('Нода'),
      '#default_value' => $config->get('related_node') ? Node::load($config->get('related_node')) : NULL,
      '#tags' => TRUE,
    ];

    return parent::buildForm($form, $form_state);
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $node_value = $form_state->getValue('related_node');
    $nid = !empty($node_value) ? $node_value[0]['target_id'] : NULL;

    $this->config('first_page.settings')
      ->set('enabled', $form_state->getValue('enabled'))
      ->set('name', $form_state->getValue('name'))
      ->set('related_node', $nid)
      ->save();

    parent::submitForm($form, $form_state);
  }
}
