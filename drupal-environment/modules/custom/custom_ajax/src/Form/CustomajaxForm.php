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
  // public function getPosts(){
  //   return CustomajaxController::apiCall("ajax", ["arg"]);
  // }
  /**
   * {@inheritdoc}
   */
  public function getPosts(array &$form, FormStateInterface $form_state) {
      $queries = [];
      $queries['reddit'] = $form_state->getValue('reddit_queries');
      $queries['twitter'] = $form_state->getValue('twitter_queries');

      return CustomajaxController::apiCall("ajax", $queries);

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
    $form['reddit_queries'] = [
      '#type' => 'hidden',
      '#value' => json_encode([
        'specificity' => '/r/aww',
        'filter' => 'none'
      ])
    ];
    $form['twitter_queries'] = [
      '#type' => 'hidden',
      '#value' => json_encode([
        'specificity' => 'billmurray',
        'filter' => 'none'
      ])
    ];

    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Get more posts'),
      '#button_type' => 'primary',
    );

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
