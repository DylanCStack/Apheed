<?php
/**
 * @file
 * Contains \Drupal\custom_ajax\Form\CustomajaxForm.
 */
namespace Drupal\custom_ajax\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

use Drupal\custom_ajax\Controller\CustomajaxController;
/**
 * Implements an homebase form.
 */
class CustomajaxForm extends FormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'custom_ajax_form';
  }
  public function getPosts(){
    return CustomajaxController::apiCall("ajax", ["arg"]);
  }
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $fid = 0) {

    $form['getFeed'] = [
      '#type' => 'button',
      // '#title' => CustomajaxController::test()
      '#value' => (string) $fid,
      '#ajax' => [
          'callback' => array($this, 'getPosts'),
          'event' => 'click',
          'progress' => array(
            'type' => 'throbber',
            'message' => t('Reloading'),
          ),
        ],
    ];

    return $form;
  }
  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {

  }
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

  }
}
