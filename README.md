# Edgewise PHP SDK

The Edgewise PHP SDK provides convenient access to the
Edgewise GraphQL API from applications written in PHP.

An access token is required. [One can be generated in Edgewise](https://sellercentral.edgewiserealty.com/profile/access-tokens). Make sure to
write down the access token when it is created, as we
do not store it, and you will not be able to retrieve
it again.

## Manual Installation

To use the SDK, include the init.php file.

```php
require_once('/path/to/edgewise-php-sdk/init.php');
```

## Dependencies

The SDK require the following extensions in order to work properly:

- curl

## Getting Started

Retrieve a project:

```php
$edgewise = new \Edgewise\EdgewiseClient(['access_token' => 'my_edgewise_access_token']);
$project = $edgewise->projects->get("project_id_or_slug");
print_r($project);
```

Contact a project (upserts a lead):

```php
$edgewise = new \Edgewise\EdgewiseClient(['access_token' => 'my_edgewise_access_token']);
$project_contact = $edgewise->projects->contact([
  "projectId" => $project_id,
  "name" => "Peter Parker",
  "email" => "peter@dailybugle.com",
  "text" => "Testing PHP SDK."
]);
print_r($project_contact);
```

## Examples

You can use Docker to run a any of the SDK examples.
Simply enter your access token and project ID, and edit the path to
the example you want to run.

```bash
docker run -it --rm \
--name edgewise-phpsdk-example \
-e EDGEWISE_ACCESS_TOKEN=my_edgewise_access_token \
-e EDGEWISE_PROJECT_ID=project_id_or_slug \
-v "$PWD":/otp/app \
-w /otp/app/examples/ \
php:8.0-cli php project_info.php
```

> The `--rm` option removes the container after it exits.
