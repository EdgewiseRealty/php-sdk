<?php
namespace Edgewise;

/**
 */
class EdgewiseClient
{
  const DEFAULT_ENDPOINT =  'https://api.edgewiserealty.com/graphql';

  private $token;
  private $endpoint;
  private $services;
  private $version;

  /**
   */
  function __construct($config)
  {
    $this->version = file_get_contents("../VERSION");

    if (array_key_exists("access_token", $config)) {
      $this->token = $config["access_token"];
    } else {
      throw new \Exception("Edgewise API access token is required.");
    }

    $this->endpoint = (array_key_exists("endpoint", $config))
      ? $config["endpoint"]
      : getenv('EDGEWISE_ENDPOINT') ?: self::DEFAULT_ENDPOINT;

    $this->services = [];
  }

  /**
   */
  public function __get($name)
  {
    $services_map = [
      "leads" => \Edgewise\Lead::class,
      "projects" => \Edgewise\Project::class
    ];

    if (array_key_exists($name, $services_map)) {
      if (!array_key_exists($name, $this->services)) {
        $this->services[$name] = new $services_map[$name]($this);
      }
      return $this->services[$name];
    } else {
      return null;
    }
  }

  /**
   */
  public function encodeQuery($query)
  {
    return json_encode($query, JSON_FORCE_OBJECT);
  }

  /**
   */
  public function request($query)
  {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $this->endpoint);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
      "content-type: application/json",
      "authorization: Bearer $this->token",
      "edgewise-client-name: PHPSDK",
      "edgewise-client-id: $this->version"
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FAILONERROR, true);
    
    $result = curl_exec($ch);
    $error_msg;

    if (curl_errno($ch)) {
      $error_msg = curl_error($ch);
    }

    return [
      "request_error" => $error_msg,
      "result" => $result,
      "info" => curl_getinfo($ch)
    ];
  }

  /**
   */
  public function handleResponse($response)
  {
    $info = $response['info'];
    $status_code = $info['http_code'];

    if ($status_code == 200) {
      $body = json_decode($response['result'], true);

      if (array_key_exists('errors', $body)) {
        throw new \Exception($body["errors"][0]["message"]);
      } else {
        return $body["data"];
      }
    } elseif (isset($response["request_error"])) {
      throw new \Exception($response["request_error"]);
    } else {
      throw new \Exception("Edgewise request error ($status_code).");
    }
  }
}
?>