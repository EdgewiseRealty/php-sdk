<?php
namespace Edgewise;

class Lead
{
  private $client;

  /**
   */
  function __construct($client)
  {
    $this->client = $client;
  }

  /**
   * Response array keys:
   *   id
   *   name
   *   email
   *   phone
   *   isAgent
   *   status
   *   origin
   *   source
   *   metadata
   *   address
   *     thoroughfare
   *     locality
   *     administrativeArea
   *     postalCode
   *   insertedAt
   *   updatedAt
   *   
   * @return array
   */
  public function get($lead_id)
  {
    $query = $this->client->encodeQuery([
      "query" => $this->getQuery(),
      "variables" => ["id" => $lead_id]
    ]);

    $response = $this->client->request($query);
    return $this->client->handleResponse($response)["lead"];
  }

  /**
   */
  private function getQuery()
  {
    return 'query PHPSdkGetLead($id: ID!) {
      lead(id: $id) {
        id
        name
        email
        phone
        isAgent
        status
        origin
        source
        metadata
        address {
          thoroughfare
          locality
          administrativeArea
          postalCode
        }
        insertedAt
        updatedAt
      }
    }';
  }
}
