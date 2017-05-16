<?php
namespace Drupal\custom_ajax\Controller;

use Drupal\Core\Controller\ControllerBase;
// use Drupal\Core\Session\AccountInterface;//
use Symfony\Component\HttpFoundation\Request;//

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;

use Drupal\node\Entity\Node;// will replace with user
use \Drupal\user\Entity\User;
// use Drupal\Core\Render\RendererInterface;// would be best practice instead of druapl_render...
class CustomajaxController extends ControllerBase {
  /**
  * Display the markup.
  *
  * @return array
  */
  static function apiCall($js, $args) {
    // $curl = curl_init();

    $url = 'http://localhost:8000/api/asdf';
    $data = array('key1' => 'value1', 'key2' => 'value2');

    // use key 'http' even if you send the request to https://...
    $options = array(
      'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
      )
    );
    // $context  = stream_context_create($options);
    // $result = file_get_contents($url, false, $context);
    $result = file_get_contents($url);
    // var_dump($result);

    if ($result === FALSE) { $result = "<h1>AJAX RESPONSE FAILURE</h1>"; }
    // $result = json_decode($result);


  $html = "<h1>AJAX RESPONSE SUCCESS</h1>";
  $selector = "#feed-repo";

  $response = new AjaxResponse();
  $response->addCommand(new HtmlCommand($selector, $result));
  // return $response;
  return $response;
}
static function test(){
  return "test working";
}
}
// // to add ajax on event in render array
// // for sure works with forms
// '#ajax' => [
//     'callback' => array($this, 'validateEmailAjax'),
//     'event' => 'change',
//     'progress' => array(
//       'type' => 'throbber',
//       'message' => t('Verifying email...'),
//     ),
//   ],// use for predictive badges/levels
