<?php
/**
 * @file
 * Contains \Drupal\custom_ajax\Form\CustomajaxForm.
 */
namespace Drupal\custom_ajax\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

use Drupal\Core\Session\AccountProxyInterface;

use Drupal\custom_ajax\Controller\CustomajaxController;

use Drupal\taxonomy\Entity\Term;
use Drupal\node\Entity\Node;
use Drupal\user\Entity\User;

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
      $queries['queries'] = $form_state->getValue('queries');
      // $queries['twitter'] = $form_state->getValue('twitter_queries');

      return CustomajaxController::apiCall("ajax", $queries);

  }
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $fid = 1) {
    $user = User::load(\Drupal::currentUser()->id());
    @$feed = Node::load($user->get('field_my_feeds')->getValue()[$fid-1]['target_id']);
    if(!$feed){
        $form['actions']['#type'] = 'actions';
        $form['actions']['submit'] = array(
          '#type' => 'submit',
          '#value' => $this->t('You have no Feed ' . $fid),
          '#button_type' => 'primary',
        );
        return $form;
    }
    $all_queries = $feed->get('field_query')->getValue();

    $load_queries = [];
    foreach ($all_queries as $key => $value) {
      $load_queries[] = $value['target_id'];
    }
    $queries = Node::LoadMultiple($load_queries);

    $pre_json = [];
    foreach ($queries as $index => $node) {
      $domain = $node->get('field_domain')->getValue()[0]['value'];
      $specificity = $node->get("field_specificity")->getValue()[0]["value"];
      // $pre_json[] = $domain[0]["value"];
      $pre_json[] = ["domain"=>$domain,"specificity"=>$specificity, "filter"=>"none"];
    }

    $query_json = json_encode($pre_json);


    $form_queries = [];

    $form['getFeed'] = [
      '#type' => 'button',
      // '#title' => CustomajaxController::test()
      '#value' => 'Get My Posts',
      '#ajax' => [
          'callback' => array($this, 'getPosts'),
          'event' => 'click',
          'progress' => array(
            'type' => 'throbber',
            'message' => t('Reloading'),
          ),
        ],
    ];
    $form['queries'] = [
      '#type' => 'hidden',
      '#value' => $query_json,
    ];
    // $form['twitter_queries'] = [
    //   '#type' => 'hidden',
    //   '#value' => json_encode([
    //     'domain' => 'twitter.com',
    //     'specificity' => 'billmurray',
    //     'filter' => 'none'
    //   ])
    // ];

    // $form['actions']['#type'] = 'actions';
    // $form['actions']['submit'] = array(
    //   '#type' => 'submit',
    //   '#value' => $this->t('Get more posts'),
    //   '#button_type' => 'primary',
    // );

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
