<?php 
require '../init.php';

try {
  $access_token = getenv('EDGEWISE_ACCESS_TOKEN');
  $project_id = getenv('EDGEWISE_PROJECT_ID');
  
  $config = ["access_token" => $access_token];
  $edgewise = new \Edgewise\EdgewiseClient($config);

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