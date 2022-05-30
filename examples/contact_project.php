<?php 
require '../init.php';

try {
  $access_token = getenv('EDGEWISE_ACCESS_TOKEN');
  $config = ["access_token" => $access_token];
  $edgewise = new \Edgewise\EdgewiseClient($config);
  $project_id = 8;

  print_r($edgewise->projects->contact([
    "projectId" => $project_id,
    "name" => "Peter Parker",
    "email" => "peter@dailybugle.com",
    "text" => "Testing PHP SDK."
  ]));

} catch (\Exception $e) {
  echo 'Error: ',  $e->getMessage(), "\n";
}
?>