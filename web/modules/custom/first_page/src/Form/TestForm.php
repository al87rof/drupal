<?php declare(strict_types = 1);

namespace Drupal\first_page\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a First Page form.
 */
final class TestForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'first_page_test';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['text_field'] = [
      '#type' => 'textfield',
      '#title' => t('Enter text'),
      '#required' => TRUE,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => t('Submit'),
      '#ajax' => [
        'callback' => '::ajaxSubmitCallback',
        'wrapper' => 'my-result',
        'effect' => 'fade',
      ],
    ];

    // Контейнер для результата
    $form['result'] = [
      '#type' => 'markup',
      '#markup' => '<div id="my-result"></div>',
    ];

    return $form;
  }


  // AJAX callback
  public function ajaxSubmitCallback(array &$form, FormStateInterface $form_state) {
    $value = $form_state->getValue('text_field');

    return [
      '#type' => 'markup',
      '#markup' => '<p><strong>Результат: ' . $value . '</strong></p>',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state): void {
    // @todo Validate the form here.
    // Example:
    // @code
    //   if (mb_strlen($form_state->getValue('message')) < 10) {
    //     $form_state->setErrorByName(
    //       'message',
    //       $this->t('Message should be at least 10 characters.'),
    //     );
    //   }
    // @endcode
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $this->messenger()->addStatus($this->t('The message has been sent.'));
    $form_state->setRedirect('<front>');
  }

}
