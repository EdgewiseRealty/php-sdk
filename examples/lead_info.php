<?php 
require '../init.php';

try {
  $access_token = getenv('EDGEWISE_ACCESS_TOKEN');
  $lead_id = getenv('EDGEWISE_LEAD_ID');

  $config = ["access_token" => $access_token];
  $edgewise = new \Edgewise\EdgewiseClient($config);

  print_r($edgewise->leads->get($lead_id));

} catch (\Exception $e) {
  echo 'Error: ',  $e->getMessage(), "\n";
}
?>