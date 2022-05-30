<?php
namespace Edgewise;

class Project
{
  private $client;

  /**
   */
  function __construct($client)
  {
    $this->client = $client;
  }

  /**
   */
  public function get($project_id)
  {
    $query = $this->client->encodeQuery([
      "query" => $this->getQuery(),
      "variables" => ["id" => $project_id]
    ]);

    $response = $this->client->request($query);
    return $this->client->handleResponse($response)["project"];
  }

  /**
   */
  public function getWalkScore($project_id)
  {
    $query = $this->client->encodeQuery([
      "query" => $this->getWalkScoreQuery(),
      "variables" => ["id" => $project_id]
    ]);

    $response = $this->client->request($query);
    return $this->client->handleResponse($response)["project"]["walkScore"];
  }

  /**
   */
  public function allImages($project_id)
  {
    $query = $this->client->encodeQuery([
      "query" => $this->allImagesQuery(),
      "variables" => ["id" => $project_id]
    ]);

    $response = $this->client->request($query);
    return $this->client->handleResponse($response)["project"]["images"];
  }

  /**
   */
  public function allPublicDocuments($project_id)
  {
    $query = $this->client->encodeQuery([
      "query" => $this->allPublicDocumentsQuery(),
      "variables" => ["id" => $project_id]
    ]);

    $response = $this->client->request($query);
    $documents = $this->client->handleResponse($response)["project"]["documents"];
    return array_filter($documents, function($document) {
      return $document["public"];
    });
  }

  /**
   */
  public function allUnits($project_id)
  {
    $query = $this->client->encodeQuery([
      "query" => $this->allUnitsQuery(),
      "variables" => ["id" => $project_id]
    ]);

    $response = $this->client->request($query);
    return $this->client->handleResponse($response)["project"]["units"];
  }

  /**
   */
  public function allSecondarySources($project_id)
  {
    $query = $this->client->encodeQuery([
      "query" => $this->allSecondarySourcesQuery(),
      "variables" => ["id" => $project_id]
    ]);

    $response = $this->client->request($query);
    return $this->client->handleResponse($response)["project"]["secondaryLeadSources"];
  }

  /**
   */
  public function contact($input)
  {
    $query = $this->client->encodeQuery([
      "query" => $this->contactQuery(),
      "variables" => ["input" => $input]
    ]);

    $response = $this->client->request($query);
    return $this->client->handleResponse($response)["contactProject"];
  }

  /**
   */
  private function getQuery()
  {
    return 'query PHPSdkGetProject($id: ID!) {
      project(id: $id) {
        id
        title
        slug
        status
        address {
          thoroughfare
          locality
          administrativeArea
          postalCode
        }
        salesOffice {
          phone
          email
        }
        overview
        overviewHeadline
        insertedAt
        updatedAt
      }
    }';
  }

  /**
   */
  private function getWalkScoreQuery()
  {
    return 'query PHPSdkGetProjectWalkScore($id: ID!) {
      project(id: $id) {
        id
        title
        slug
        walkScore {
          link
          walkScore
          walkScoreDescription
          bikeScore
          bikeScoreDescription
          transitScore
          transitScoreDescription
        }
      }
    }';
  }

  /**
   */
  private function allSecondarySourcesQuery()
  {
    return 'query PHPSdkAllProjectSecondarySources($id: ID!) {
      project(id: $id) {
        id
        title
        slug
        secondaryLeadSources {
          id
          name
        }
      }
    }';
  }

  /**
   */
  private function allImagesQuery()
  {
    return 'query PHPSdkAllProjectImages($id: ID!) {
      project(id: $id) {
        id
        title
        slug
        images {
          id
          title
          sequence
          url
        }
      }
    }';
  }

  /**
   */
  private function allPublicDocumentsQuery()
  {
    return 'query PHPSdkAllProjectPublicDocument($id: ID!) {
      project(id: $id) {
        id
        documents {
          id
          description
          filename
          filemime
          filesize
          public
          url
        }
      }
    }';
  }

  /**
   */
  private function allUnitsQuery()
  {
    return 'query PHPSdkAllProjectUnits($id: ID!) {
      project(id: $id) {
        id
        title
        slug
        units {
          id
          title
          status
          price
          floorPlan {
            id
            title
          }
        }
      }
    }';
  }

  private function contactQuery()
  {
    return 'mutation PHPSdkContactProject($input: ContactProjectInput!) {
      contactProject(input: $input) {
        id
      }
    }';
  }
}
