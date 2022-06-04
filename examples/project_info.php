<?php 
require '../init.php';

try {
  $access_token = getenv('EDGEWISE_ACCESS_TOKEN');
  $project_id = getenv('EDGEWISE_PROJECT_ID');

  $config = ["access_token" => $access_token];
  $edgewise = new \Edgewise\EdgewiseClient($config);

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