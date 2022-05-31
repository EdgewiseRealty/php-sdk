<?php 
require '../init.php';

try {
  $access_token = getenv('EDGEWISE_ACCESS_TOKEN');
  $config = ["access_token" => $access_token];
  $edgewise = new \Edgewise\EdgewiseClient($config);
  $lead_id = 5000;

  print_r($edgewise->leads->get($lead_id));

} catch (\Exception $e) {
  echo 'Error: ',  $e->getMessage(), "\n";
}
?>