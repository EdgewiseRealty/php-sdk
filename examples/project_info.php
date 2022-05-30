<?php 
require '../init.php';

try {
  $access_token = getenv('EDGEWISE_ACCESS_TOKEN');
  $config = ["access_token" => $access_token];
  $edgewise = new \Edgewise\EdgewiseClient($config);
  $project_id = 8;

  print_r($edgewise->projects->get($project_id));
  // print_r($edgewise->projects->allSecondarySources($project_id));
  // print_r($edgewise->projects->getWalkScore($project_id));
  // print_r($edgewise->projects->allPublicDocuments($project_id));
  // print_r($edgewise->projects->allImages($project_id));
  // print_r($edgewise->projects->allUnits($project_id));

} catch (\Exception $e) {
  echo 'Error: ',  $e->getMessage(), "\n";
}
?>