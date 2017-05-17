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
    $feed = Node::load($user->get('field_my_feeds')->getValue()[$fid-1]['target_id']);
    $all_queries = $feed->get('field_query')->getValue();

    $loaded_queries = [];
    foreach ($all_queries as $key => $value) {
      $load_queries[] = $value['target_id'];
    }

    $queries = Node::LoadMultiple($load_queries);
    $tids = [];//taxonomy term ids
    foreach ($queries as $index => $node) {
      $in_tids = FALSE;
      $new_tid = $node->get("field_domain")->getValue()[0]['target_id'];
      foreach ($tids as $key => $value) {
        if($new_tid == $value){
          $in_tids = TRUE;
        }
      }
      if(!$in_tids){
        $tids[$new_tid] = $new_tid;
      }
    }
    $terms = Term::LoadMultiple($tids);

    $pre_json = [];
    foreach ($queries as $index => $node) {
      $domain_term = $node->get("field_domain")->getValue();
      $domain = $domain_term->get("name")->getValue();
    }

    $query_json = json_encode($pre_json);

    print '<pre>';
    print_r($query_json);
    print'</pre>';
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
      '#value' => json_encode([
        'reddit' => [
          [
          'specificity' => 'aww',
          'filter' => 'none'
          ],
          [
          'specificity' => 'pics',
          'filter' => 'none'
          ],
        ],
        'twitter' => [
          [
            'specificity' => 'billmurray',
            'filter' => 'none'
          ],
          [
            'specificity' => 'SHAQ',
            'filter' => 'none'
          ],
        ]
      ])
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
