<?php 
require '../init.php';

try {
  $access_token = getenv('EDGEWISE_ACCESS_TOKEN');
  $project_id = getenv('EDGEWISE_PROJECT_ID');
  
  $config = ["access_token" => $access_token];
  $edgewise = new \Edgewise\EdgewiseClient($config);

  /**
   * See GraphQL API ContactProjectInput for required / optional fields.
   * https://edgewiserealty.com/docs/api-reference/types/ContactProjectInput
   */

  $project_contact = $edgewise->projects->contact([
    "projectId" => $project_id,
    "name" => "Peter Parker",
    "email" => "peter@dailybugle.com",
    "text" => "Testing PHP SDK."
  ]);

  print_r($project_contact);

} catch (\Exception $e) {
  echo 'Error: ',  $e->getMessage(), "\n";
}
?>